<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * @OA\Post(
     *  path="/v1/classroom/getin",
     *  description="Ingresar a la sala de clases",
     *  @OA\Response(
     *      response="default",
     *      description="Respuesta de ingreso",
     *  )
     * )
     */
    public function getin() {
        return [
            "classroom" => "M2-302",
            "subject" => "INFB8090",
            "entrance" => "2022-06-15T03:31:15.807Z",
        ];
    }

    /**
     * @OA\Post(
     *  path="/v1/classroom/getout",
     *  description="Retirarse de la sala de clases",
     *  @OA\Response(
     *      response="default",
     *      description="Respuesta de salida",
     *  )
     * )
     */
    public function getout() {
        return [
            "classroom" => "M2-302",
            "subject" => "INFB8090",
            "entrance" => "2022-06-15T03:31:15.807Z",
            "leaving" => "2022-06-15T03:31:15.807Z",
        ];
    }

    /**
     * @OA\Get(
     *  path="/v1/classroom/attendances",
     *  description="Lista de asistencias",
     *  @OA\Response(
     *      response="default",
     *      description="Respuesta de asistencias",
     *  )
     * )
     */
    public function attendances() {
        return [
            "classroom" => "M2-302",
            "subject" => "INFB8090",
            "entrance" => "2022-06-15T01:19:55.984Z",
            "leaving" => "2022-06-15T01:19:55.984Z",
        ];
    }
}
