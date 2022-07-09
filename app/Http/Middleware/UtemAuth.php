<?php

namespace App\Http\Middleware;

use App\Services\JWTService;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UtemAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $auth = $request->header('Authorization');
        if(!$auth){
            return abort(401, 'Necesitas autenticarte para poder ver este recurso.');
        }

        $jwt = explode(' ', $auth);
        if($jwt[0] != "Bearer") {
            return abort(400, "El método de autenticación esperado es 'Bearer Token'");
        }

        $verify = JWTService::verifyToken($jwt[1]);

        if(!$verify['ok']){
            return abort(response()->json($verify['response'], $verify['suggestedStatusCode']));
        }

        return $next($request);
    }
}
