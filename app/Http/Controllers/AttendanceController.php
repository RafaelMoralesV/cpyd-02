<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetInRequest;
use App\Http\Requests\GetOutRequest;
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
        $data['leaving'] = Carbon::createFromFormat("Y-m-d\TH:i:s.v\Z", $data['leaving'])->toDateTimeString();

        $keys = array_flip(['email', 'classroom', 'subject', 'entrance']);
        $att = Attendance::where(array_intersect_key($data, $keys))->first();

        if(!$att) {
            return abort(404, 'No se ha encontrado una asistencia con esos parámetros');
        }

        $att->update($data);

        return $att;
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
        return Attendance::where(['email' => session('email')])->get();
    }
}
