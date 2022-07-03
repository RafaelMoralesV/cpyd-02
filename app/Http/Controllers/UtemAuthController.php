<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return [
            "classroom" => "M2-302",
            "subject" => "INFB8090",
            "entrance" => "2022-06-15T03:35:01.907Z",
            "leaving" => "2022-06-15T03:35:01.907Z",
            "email" => "ssalazar@utem.cl",
        ];
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
    public function result() {
        return [
            "classroom" => "M2-302",
            "subject" => "INFB8090",
            "entrance" => "2022-06-15T03:35:01.907Z",
            "leaving" => "2022-06-15T03:35:01.907Z",
            "email" => "ssalazar@utem.cl",
        ];
    }
}
