<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index(Request $request){
        if(!$request->session()->has('user'))
            return redirect('/');
        return view('body/body');
        exit();
    }

    public function validarUsuario(Request $request){
        if(!$request->isMethod('post'))
            return redirect('/');
        $inputs = $request->all();
        $user = DB::table('tusuario')->where('usuario','=',$inputs["usuario"])
                                    ->where('pass','=',md5(sha1($inputs['password'])))->first();
        if(!is_null($user)){
            $data = [
                'id' => $user->id,
                'usuario' => $user->usuario,
                'rol_id' => $user->rol_id,
                'persona_id' => $user->persona_id
            ];
            $request->session()->put('user',$data);
            return redirect('/home');
        }else{
            \Session::flash('message_login','Error, Ingrese datos correctos');
            return redirect('/');
        }
        exit();
    }

    public function salir(Request $request){
        $request->session()->forget('user');
        $request->session()->regenerate();
        return redirect('/');
    }
}
