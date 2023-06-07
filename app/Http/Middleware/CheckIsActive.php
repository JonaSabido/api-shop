<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken(); // Obtiene el token del encabezado de autorización

        // Realiza la lógica para verificar que el token contiene el id_profile 2
        // Puedes adaptar este código según tu método de autenticación y estructura del token

        if ($token) {
            // Decodifica el token (por ejemplo, usando JWT)
            $decodedToken = JWTAuth::parseToken()->getPayload(); // Decodificar el token
            // Verifica el valor del id_profile en el token decodificado
            if ($decodedToken->get('user')->active === 1 ) {
                return $next($request);
            }
        }

        // Si el token no contiene el id_profile 2, puedes devolver una respuesta de error o redireccionar a otra ruta
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
