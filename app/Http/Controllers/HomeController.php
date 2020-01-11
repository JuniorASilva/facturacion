<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;

class HomeController extends Controller
{
    //

    public function index(Request $request)
    {
        if (!$request->session()->has('user'))
        {
            return redirect('/');
        }
        $option = 'home';
        return view('layout/home',compact('option'));
        echo 'Bienvenido';
        exit;
    }

    public function validarUsuario(Request $request)
    {
        if(!$request->isMethod('post'))
            return redirect('/');
        $inputs = $request->all();
        //$user = DB::table('tusuario')->where('usuario',$inputs['usuario'])->where('pass',md5(sha1($inputs['password'])))->first();
        $user = (new Usuario())->getUsuarioWhere([
            'usuario'   => $inputs['usuario'],
            'pass'      => md5(sha1($inputs['password']))
        ]);

        if(!is_null($user)){
            
            $data = [
                'id' => $user->id,
                'usuario' => $user->usuario,
                'rol_id' => $user->rol_id,
                'persona_id' => $user->persona_id
            ];
            $request->session()->put('user',$data);
            return redirect('/home');
            echo 'logueado';
        }
        else
        {
            \Session::flash('message_login','Error, Ingrese los datos correctos');
             return redirect('/');
        }
       
    }

    public function salir(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->regenerate();
        return redirect('/');
    }
    
}
