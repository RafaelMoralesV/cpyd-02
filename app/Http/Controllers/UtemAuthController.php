<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationResultRequest;
use Carbon\Carbon;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UtemAuthController extends Controller
{
    /**
     * @OA\Get(
     *  path="/v1/authenticaiton/login",
     *  description="Login",
     *  @OA\Response(
     *      response="default",
     *      description="Respuesta de Login",
     *  )
     * )
     */
    public function login(Request $request)
    {
        $res = Http::withHeaders([
            "X-API-TOKEN" => env("X_API_TOKEN"),
            "X-API-KEY" => env("X_API_KEY"),
        ])->withBody(json_encode([
            "failedUrl" => route("success"),
            "successUrl" => route("success")
        ]), "application/json")
            ->post(env("X_API_URL") . "/v1/tokens/request")
            ->json();

        $request->session()->put('API', [
            'token' => $res['token'],
            'sign' => $res['sign'],
        ]);

        return response()->json($res);
    }

    /**
     * @OA\Get(
     *  path="/v1/authentication/result",
     *  description="Auth result",
     *  @OA\Response(
     *      response="default",
     *      description="Resultado de autenticacion",
     *  )
     * )
     */
    public function result(AuthenticationResultRequest $request)
    {
        $params = $request->validated();

        if (!$request->session()->has('API')) {
            return response()->json([], 403);
        }

        $sign = $request->session()->get('API.sign');
        $jwt = $params['jwt'];

        try {
            $decoded = JWT::decode($jwt, new Key($sign, 'HS512'));
            $exp = Carbon::createFromTimestamp($decoded->exp);

            return response()->json([
                'ok' => true,
                'jwt' => $jwt,
                'expiresAt' => $exp,
                'humanReadable' => [
                    'expiresAt' => $exp->format('h:i:s, d/M/y'),
                ],
            ]);
        } catch (SignatureInvalidException $e) {
            return response()->json([
                'ok' => false,
                'message' => "No se ha podido validar la identidad de la petición."
            ], 401);
        } catch (\DomainException $e) {
            return response()->json([
                'ok' => false,
                'message' => "El token JWT enviado está malformado."
            ], 400);
        } catch (ExpiredException $e) {
            return response()->json([
                'ok' => false,
                'message' => "Su sesión ha finalizado, ingrese nuevamente."
            ], 401);
        }
    }
}
