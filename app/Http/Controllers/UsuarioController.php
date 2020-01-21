<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Usuario;
use App\Models\Utils;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('user'))
            return redirect('/');


        $usuarios = (new Usuario())->getAllUsuarios();
        $option = 'usuarios';

        return view('usuarios.index', compact('usuarios', 'option'));
    }

    public function nuevoUsuario(Request $request)
    {
        if (!$request->session()->has('user'))
            return redirect('/');

        if ($request->isMethod('post')) {
            $p = new Persona();

            $res = $p->getPersonaWhereLike([
                'nombres' => $request->input('nombres'),
                'apellidos' => $request->input('apellidos')
            ]);

            if ($res != null && count($res->toArray()) != 0) {
                $id_persona = $res->id;
            } else {
                $p->nombres = $request->input('nombres');
                $p->apellidos = $request->input('apellidos');
                $p->direccion = '';
                $p->fch_nac = date('Y-m-d');
                $p->telefono = '123456789';
                $p->genero = 1;
                $p->save();
                $id_persona = $p->id;
            }

            $is_save_user = Usuario::saveUser([
                'usuario' => $request->input('usuario'),
                'pass' => md5(sha1($request->input('pass'))),
                'persona' => $id_persona,
                'rol' => $request->input('roles'),
            ]);

            if ($is_save_user) {
                \Session::flash('message_signup', 'Usuario creado correctamente');
            } else {
                \Session::flash('message_signup', 'Ingrese datos correctamente');
            }
        }

        $option = 'usuarios';
        $roles = (new Utils())->getRoles();

        return view('usuarios.nuevos', compact('option', 'roles'));
    }

    public function editarUsuario(Request $request, $id){
        $option = 'usuarios';
        $roles = (new Utils())->getRoles();
        $usuario = (new Usuario())->getAllUsuariosById($id);
        return view('usuarios.nuevos', compact('option', 'roles','usuario'));
    }

    public function consultaUsuario(Request $request)
    {
        if (!$request->session()->has('user')) {
            return redirect('/');
        }

        if (!$request->isMethod('post')) {
            return redirect('/');
        }

        $u = new Usuario();
        $res = $u->getUsuarioWhere([
            'usuario' => $request->input('usuario')
        ]);

        if (is_null($res)) {
            return response()->json([
                'status'  => 200,
                'data'    => [],
                'message' => 'No existe usuario'
            ], 200);
        } else {
            return response()->json([
                'status'  => 202,
                'data'    => [],
                'message' => 'El usuario ya existe'
            ], 202);
        }
    }
}
//agregar la actualizacion del usuario
//validar el usuario
//validar si es metodo post