<?php

namespace App\Http\Controllers;

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
    public function login() {
        return Http::withHeaders([
            "X-API-TOKEN" => env("X_API_TOKEN"),
            "X-API-KEY" => env("X_API_KEY"),
        ])->withBody(json_encode([
            "failedUrl" => route("success"),
            "successUrl" => route("success")
        ]), "application/json")
        ->post(env("X_API_URL") . "/v1/tokens/request")
        ->body();
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
    public function result(Request $request) {
        $jwt = $request->validate(['jwt' => 'required'])['jwt'];

        return [
            "classroom" => "M2-302",
            "subject" => "INFB8090",
            "entrance" => "2022-06-15T03:35:01.907Z",
            "leaving" => "2022-06-15T03:35:01.907Z",
            "email" => "ssalazar@utem.cl",
        ];
    }
}
