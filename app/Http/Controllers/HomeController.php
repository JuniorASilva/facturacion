<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function login(Request $request)
    {
        if (!$request->session()->has('user')){
            return view('layout/login');
        } else {
            return redirect('home');
        }
    }
    
    public function index(Request $request)
    {
        if (!$request->session()->has('user'))
            return redirect('/');

        $option = 'home';
        return view('layout.home', compact('option'));
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

        $inputs['pass'] = md5(sha1($inputs['password']));

        $user = (new Usuario())->getUsuarioWhere([
            'usuario' => $inputs['usuario'],
            'pass'    => $inputs['pass']
        ]);

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
