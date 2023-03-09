<?php

namespace App\Http\Controllers;


use DB;
use Illuminate\Support\Facades\Auth;
use App\User;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
            return view('home');
    }

    public function sessionAudita()
    {
        $usuario_ing = Auth::user()->empleado_id;
        $arrayA = array();
        $arrayL = array();
        $today = new \DateTime("now");
        array_push($arrayA, 'AsesorCC');
        array_push($arrayL, 'LiderCC', 'AdminCC');
        $varL = Auth::user()->evaluarole($arrayL);
        $var = Auth::user()->evaluarole($arrayA);
        if ($var != 0 && $varL==0) {
           $resultA=DB::connection('mysql_solicitudes')->table('sessionaudita')->insert(['usuario_ing'=>$usuario_ing,'created_at'=>$today]);
            $result = DB::connection('pgsql')->table('users')->where('empleado_id', $usuario_ing)->update(['estado' => 'I']);
            $array_response['status'] = 200;
        } else {
            $array_response['status'] = 300;
        }

        return response()->json($array_response, 200);
    }
    public function impersonate($user_id)
    {
        $user = User::find($user_id);
        Auth::user()->impersonate($user);
        return redirect()->route('home');
    }
    public function impersonate_leave()
    {
        Auth::user()->leaveImpersonation();
        return redirect()->route('home');
    }
}
