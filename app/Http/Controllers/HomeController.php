<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('user'))
            return redirect('/');

        return view('body.body');
    }

    public function salir(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->regenerate();
        return redirect('/');
    }
    
    public function validarUsuario(Request $request)
    {
        if (!$request->isMethod('post'))
            return redirect('/');

        $inputs = $request->all();
        $encrypt = md5(sha1($inputs['pass']));

        $user = DB::table('tusuario')
                  ->where('usuario', $inputs['usuario'])
                  ->where('pass', $encrypt)
                  ->first();

        if (!is_null($user)) {
            $data = [
                'id'         => $user->id,
                'usuario'    => $user->usuario,
                'rol_id'     => $user->rol_id,
                'persona_id' => $user->persona_id,
            ];

            $request->session()->put('user', $data);
            return redirect('/home');

        } else {
            \Session::flash('message_login', 'Error, ingrese los datos correctos');
            return redirect('/');
        }
    }
}
