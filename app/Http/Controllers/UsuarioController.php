<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Utils;
use App\Models\Persona;

class UsuarioController extends Controller
{
    //
    public function index(Request $request)
    {
        if (!$request->session()->has('user'))
        {
            return redirect('/');
        }
        $usuarios = (new Usuario())->getAllUsuarios();
        $option = 'usuario';
        return view('usuarios/index',compact('usuarios','option'));
    }

    public function nuevoUsuario(Request $request)
    {
        if (!$request->session()->has('user'))
        {
            return redirect('/');
        }
        if($request->isMethod('post')){
            $p=new Persona();
            $res = $p->getPersonaWhereLike([
                'nombres'       => $request->input('nombres'),
                'apellidos'       => $request->input('apellidos')
            ]);
            //var_dump($res->toArray());
            if ($res != null && count($res->toArray())!=0)
                $id_persona = $res->id;
            else
            {
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
            $is_save_user = Usuario::saveUser(array(
                'usuario' => $request->input('usuario'),
                'clave' => md5(sha1($request->input('pass'))),
                'persona_id' => $id_persona,
                'rol' => $request->input('roles')
            ));
            if ($is_save_user){
                return response()->json(['status'=>200,'data'=>[],'message'=>'Registro satisfactorio']);
            }
            else{
                return response()->json(['status'=>202,'data'=>[],'message'=>'Ingrese los datos correctamente']);
            }

            /*var_dump($p);
            exit();*/


        }
        $option = 'usuario';
        $roles = (new Utils())->getRoles();
        return view('usuarios/nuevo',compact('option','roles'));
    }

    public function consultaUsuario(Request $request){
        if(!$request->session()->has('user'))
            return redirect('/');
        if(!$request->session()->has('user'))
            return redirect('/');
        
        $u = new Usuario();
        $res = null;
        if ($request->input('id')!=0)
        {
            $usuarioid = $u->getUsuarioWhere(['id'=>$request->input('id')]);
            if($is_null($usuarioid) && $usuarioid->usuario != $request->input('usuario')){
                $res = $u->getUsuarioWhere(['usuario'=>$request->input('usuario')]);        
            }
        }else{
            $res = $u->getUsuarioWhere(['usuario'=>$request->input('usuario')]);
        }
        if(is_null($res))
            return response()->json(['status'=>200,'data'=>[],'message'=>'Usuario Disponible']);
        else    
            return response()->json(['status'=>202,'data'=>[],'message'=>'El Usuario ya existe']);

        //var_dump($res);
    }

     public function editarUsuario(Request $request,$id)
    {
        $usuario = (new Usuario())->getUsuariosById($id);
        if($request->isMethod('post')){
            if(is_null($usuario))
            {
                return response()->json(['status'=>202,'data'=>[],'message'=>'Error, consulte con su administrador']);
            }
            $p= new Persona();
            $p->updatePersona([
                'nombres'    => $request->input('nombres'),
                'apellidos'  => $request->input('apellidos')
            ],[
                'id'=>$usuario->persona_id
            ]);

            $data = [
                'usuario'   => $request->input('usuario')
            ];
            if(!is_null($request->input('pass')))
            {
                $data['pass'] = md5(sha1($request->input('pass')));
            }
            Usuario::updateUsuario($data,['id'=>$usuario->id]);
            return response()->json(['status'=>200,'data'=>[],'message'=>'Actualizacion satisfactoria']);
        }

        $option = 'usuario';
        $roles = (new Utils())->getRoles();
        return view('usuarios/nuevo',compact('option','roles','usuario'));

    }

}