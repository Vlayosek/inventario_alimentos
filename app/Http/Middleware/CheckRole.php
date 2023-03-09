<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $arrayRoles = explode("|", $role);

        if (Auth::guest()) {
            return response()->view('errors.503', [], 503);

            //abort(500, 'Acceso No Autorizado!!');
        } else {
            $evalua = $request->user()->evaluarole($arrayRoles);

            if ($evalua > 0) {
                return $next($request);
            } else {
                if ($request->ajax()) {
                    return response()->view('errors.503', [], 503);

                 //   return response()->json(['Acceso no autorizado para realizar esta operaci&oacute;n'], 500);
                } else {
                    return response()->view('errors.503', [], 503);

                    //   abort(500, 'Acceso No Autorizado!!');
                }
            }
        }


    }
}
