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
                $p->estado = 1;
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
                return response()->json([
                    'status'  => 200,
                    'data'    => [],
                    'message' => 'Usuario creado correctamente'
                ], 200);
            } else {
                return response()->json([
                    'status'  => 202,
                    'data'    => [],
                    'message' => 'Error al ingresar los datos'
                ], 202);
            }
        }

        $option = 'usuarios';
        $roles = (new Utils())->getRoles();

        return view('usuarios.nuevos', compact('option', 'roles'));
    }

    public function editarUsuario(Request $request, $id){
        $usuario = (new Usuario())->getAllUsuariosById($id);
        
        if($request->isMethod('post')){
            if(is_null($usuario)){
                return response()->json(['status' => 202, 'data' => [], 'message' => 'Error, consulte con su administrador' ]);
            }
            $p = new Persona();
            $p->updatePersona([
                'nombres' => $request->input('nombres'),
                'apellidos' => $request->input('apellidos')
            ], ['id' => $usuario->persona_id]);
            $data = [
                'usuario' => $request->input('usuario')
            ];
            if(!is_null($request->input('pass'))){
                $data['pass'] = md5(sha1($request->input('pass')));
            }
            Usuario::updateUsuario($data,['id' => $usuario->id]);
            return response()->json(['status' => 200, 'data' => [], 'message' => 'Actualizacion satisfactoria']);
        }

        $option = 'usuarios';
        $roles = (new Utils())->getRoles();
        
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
        $res = null;
        if($request->input('id') != 0){
            $usuario_id = $u->getUsuarioWhere([
                'id' => $request->input('id')
            ]);
            if(!is_null($usuario_id) && $usuario_id->usuario != $request->input('usuario')){
                $res = $u->getUsuarioWhere([
                    'usuario' => $request->input('usuario')
                ]);        
            }
        }else{
            $res = $u->getUsuarioWhere([
                'usuario' => $request->input('usuario')
            ]);
        }

        if (is_null($res)) {
            return response()->json([
                'status'  => 200,
                'data'    => [],
                'message' => 'Nombre de usuario disponible'
            ], 200);
        } else {
            return response()->json([
                'status'  => 202,
                'data'    => [],
                'message' => 'Usuario no disponible'
            ], 202);
        }
    }

    public function editarUsuario($id, Request $request)
    {
        $option = 'usuarios';
        $roles = (new Utils())->getRoles();

        $usuario = Usuario::getUsuarioById($id);

        if ($request->isMethod('post')) {

            if (is_null($usuario)) {
                return response()->json([
                    'status' => 200,
                    'data' => [],
                    'message' => 'Error, consulte su administrador'
                ], 202);
            }

            Persona::updatePersona([
                'nombres' => $request->input('nombres'),
                'apellidos' => $request->input('apellidos'),
            ], [
                'id' => $usuario->persona_id
            ]);
            
            $data = [
                'usuario' => $request->input('usuario'),
            ];

            if (!is_null($request->input('pass'))) {
                $data['pass'] = md5(sha1($request->input('pass')));
            }

            Usuario::updateUser($data, ['id' => $id,]);

            return response()->json([
                'status'  => 200,
                'data'    => [],
                'message' => 'Actualizacion satisfactoria'
            ], 200);
        }

        return view('usuarios.nuevos', compact('option', 'roles', 'usuario'));
    }
}
//agregar la actualizacion del usuario
//validar el usuario
//validar si es metodo post