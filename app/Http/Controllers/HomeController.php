<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*para la base de datos hay q usar esto*/ 
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function salir(Request $request){
        $request->session()->forget('user');
        $request->session()->regenerate();
        return redirect('/');
    }

    public function index(Request $request){
        if(!$request->session()->has('user'))
        return redirect('/');
        return view('body/body');

        echo 'Bienvenido';
        exit();
    }

    public function validarusuario(Request $request){
        if(!$request->isMethod('post'))
            return redirect('/');

        $inputs = $request->all();
        $user = DB::table('tusuario')->where('usuario',$inputs['usuario'])->where('pass',md5(sha1($inputs['pass'])))->first();
        
        if(!is_null($user)){
            $data = [
               'id'         => $user->id,
               'usuario'    => $user->usuario,
               'rol_id'     => $user->rol_id,
               'persona_id' =>  $user->persona_id
            ];
            $request->session()->put('user',$data);
            return redirect('/home');
            //echo 'Logueado';
        }else{
            \Session::flash('Message_Login','Error, Ingrese datos Correctos');
            return redirect('/');
            
        }
        
        //var_dump($user);
        //exit();
    }
}
