<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetInRequest;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * @OA\Post(
     *  path="/v1/classroom/getin",
     *  description="Ingresar a la sala de clases",
     *  tags={"classroom-rest"},
     *  @OA\Response(
     *      response="default",
     *      description="Respuesta de ingreso",
     *  )
     * )
     */
    public function getin(GetInRequest $request) {
        $data = $request->validated();
        $data['email'] = session('email');
        $data['entrance'] = Carbon::createFromFormat("Y-m-d\TH:i:s.v\Z", $data['entrance'])->toDateTimeString();

        return Attendance::create($data);
    }

    /**
     * @OA\Post(
     *  path="/v1/classroom/getout",
     *  description="Retirarse de la sala de clases",
     *  tags={"classroom-rest"},
     *  @OA\Response(
     *      response="default",
     *      description="Respuesta de salida",
     *  )
     * )
     */

    public function getout(GetOutRequest $request) {
        $data = $request->validated();
        $data['email'] = session('email');
        $data['entrance'] = Carbon::createFromFormat("Y-m-d\TH:i:s.v\Z", $data['entrance'])->toDateTimeString();

        return Attendance::create($data);
    }

    /**
     * @OA\Get(
     *  path="/v1/classroom/attendances",
     *  description="Lista de asistencias",
     *  tags={"classroom-rest"},
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
