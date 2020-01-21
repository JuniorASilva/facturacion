<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Utils;
use App\Models\Persona;

class UsuarioController extends Controller
{
    public function index(Request $request){
		if(!$request->session()->has('user'))
			return redirect('/');
		$usuarios = (new Usuario())->getAllUsuarios();
		$option='usuarios';
		/*echo '<pre>';
		var_dump($u->getAllUsuarios());
		echo '</pre>';
		exit();*/
		return view('usuarios/index',compact('usuarios','option'));
	}
	public function nuevoUsuario(Request $request){
		if(!$request->session()->has('user'))
			return redirect('/');
        if($request->isMethod('post')){
        	$p = new Persona();
            $res = $p->getPersonaWhereLike([
                'nombres' => $request->input('nombres'),
                'apellidos' => $request->input('apellidos')
            ]);
            if ($res != null && count($res->toArray()) != 0)
                $id_persona = $res->id;
            else{
            
            	$p->nombres = $request->input('nombres');
            	$p->apellidos = $request->input('apellidos');
            	$p->direccion = '';
            	$p->fch_nac = date('Y-m-d');
            	$p->telefono = '123456789';
            	$p->genero =1;
            	$p->estado=1;
            	$p->save();
                $id_persona = $p->id;
                
        	}
            $is_save_user = Usuario::saveUser(array(
                "usuario" => $request->input("usuario"),
                "clave" => md5(sha1($request->input("pass"))),
                "persona" => $id_persona,
                "rol" =>  $request->input("roles")
            ));
            if($is_save_user){
                \Session::flash('message_insert','¡Ok!, Operación realizada con éxito');
            }else{
                \Session::flash('message_insert','Error');
            }
        }
        $option='usuarios';
        $roles = (new Utils())->getRoles();
		return view('usuarios/nuevos',compact('option','roles'));
	}
    public function consultaUsuario(Request $request){
        if(!$request ->session()->has('user'))
            return redirect('/');
        if(!$request->isMethod('post'))
            return redirect('/');
        $u = new Usuario();
        $res = $u->getUsuarioWhere(['usuario' => $request-> input('usuario')]);
        if(is_null($res))
            echo json_encode(['status' => 200, 'data' =>[],'message'=> 'No existe usuario']);
        else
            echo json_encode(['status' => 202, 'data' =>[],'message' => 'El usuario ya existe']);
    }
    public function editarUsuario(Request $request, $id){
        $option='usuarios';
        $roles = (new Utils())->getRoles();
        $usuario = (new Usuario())->getUsuarioById($id);
        return view('usuarios/nuevos',compact('option','roles','usuario'));
    
    }
}
