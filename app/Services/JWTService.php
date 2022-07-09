<?php

namespace App\Services;

use DomainException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use UnexpectedValueException;

class JWTService
{
    /**
     * Verifica un token JWT, y entrega un arreglo con errores en caso de fallo
     * o el JWT decodificado en caso de éxito.
     *
     * Verifica el éxito usando $arr['ok'], y accede al jwt con ['decoded']
     *
     * Obtén una respuesta Http sugerida con ['suggestedStatusCode'] en caso de fallo
     * y ['response'] para un arreglo con ['message'] y razón de fallo ['reason'].
     *
     * @param string $jwt El token a verificar
     * @return array Resultado de la verificación, según lo descrito arriba
     */
    public static function verifyToken(string $jwt): array
    {
        $response = ['ok' => false];

        if (!session()->has('API')) {
            return ['ok' => false,
                'suggestedStatusCode' => 401,
                'response' => [
                    'message' => 'Necesitas ingresar a tu cuenta UTEM para ver este recurso.',
                    'reason' => 'No se ha encontrado la llave API en la sesión',
                ],
            ];
        }

        try {
            $decoded = JWT::decode($jwt, new Key(session('API.sign'), 'HS512'));
            if (session('API.token') != $decoded->token) {
                return ['ok' => false,
                    'suggestedStatusCode' => 401,
                    'response' => [
                        'message' => 'No se ha podido verificar su token.',
                        'reason' => 'API Token en session no corresponde con el encontrado en el JWT.',
                    ],
                ];
            }

            return ['ok' => true, 'decoded' => $decoded];
        } catch (SignatureInvalidException $e) {
            $response['suggestedStatusCode'] = 401;
            $response['response'] = [
                "message" => "No se ha podido validar la identidad de la petición.",
                'reason' => $e->getMessage(),
            ];
        } catch (ExpiredException $e) {
            $response['suggestedStatusCode'] = 401;
            $response['response'] = [
                "message" => "Su sesión ha finalizado, ingrese nuevamente.",
                'reason' => $e->getMessage(),
            ];
        } catch (DomainException|UnexpectedValueException $e) {
            $response['suggestedStatusCode'] = 401;
            $response['response'] = [
                "message" => "El token JWT enviado está mal formado.",
                "reason" => $e->getMessage(),
                "jwt" => $jwt,
                "stacktrace" => $e->getTrace(),
            ];
        }

        return $response;
    }
}
