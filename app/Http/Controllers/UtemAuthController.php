<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationResultRequest;
use App\Services\JWTService;
use Carbon\Carbon;
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

        if($params['token'] != session('API.token')){
            return abort(response()->json([
                'ok' => false,
                'message' => 'No se ha podido verificar su token.',
            ], 401));
        }

        $verify = JWTService::verifyToken($params['jwt']);

        if(!$verify['ok']){
            return abort(response()->json(
                array_merge(['ok' => false], $verify['response']),
                $verify['suggestedStatusCode'],
            ));
        }

        $decoded = $verify['decoded'];
        $exp = Carbon::createFromTimestamp($decoded->exp);

        return response()->json([
            'ok' => true,
            'jwt' => $params['jwt'],
            'expiresAt' => $exp,
            'humanReadable' => [
                'expiresAt' => $exp->format('H:i:s, d/M/y'),
            ],
        ]);
    }
}
