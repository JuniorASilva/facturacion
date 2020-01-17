<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuario;
use App\Models\Utils;
use App\Models\Persona;

class UsuarioController extends Controller
{
    //
    public function index(Request $request){
    	if(!$request->session()->has('user'))
            return redirect('/');
        $usuarios = (new Usuario())->getAllUsuarios();
        $option = 'usuarios';
    	return view('usuarios/index',compact('usuarios','option'));                                     
    }

    public function nuevoUsuario(Request $request){
        if(!$request->session()->has('user'))
            return redirect('/');
        if($request->isMethod('post')){
            $p = new Persona();
            $res = $p->getPersonaWhereLike([
                "nombres" => $request->input("nombres"),
                "apellidos" => $request->input("apellidos")
            ]);
            if(count($res->toArray()) != 0){
                $id_persona = $res->id;
            }else{
                $p->nombres = $request->input('nombres');
                $p->apellidos = $request->input('apellidos');
                $p->direccion = '';
                $p->fch_nac = date('Y-m-d');
                $p->telefono = '12345679';
                $p->genero = 1;
                $p->estado = 1;
                $p->save();
                $id_persona = $res->id;
            }
            var_dump($p);
            exit();
        }
        $option = 'usuarios';
        $roles = (new Utils())->getRoles();
        return view('usuarios/nuevos',compact('option','roles'));
    }

    public function consultaUsuario(Request $request){
        if(!$request->session()->has('user'))
            return redirect('/');
        if(!$request->isMethod('post'))
            return redirect('/');
        $u = new Usuario();
        $res = $u->getUsuarioWhere(['usuario' => $request->input('usuario')]);
        if($res == null){
            return response()->json(['status' => 200, 'data' => [], 'message' => "No existe usuario"]);
        }else{
            return response()->json(['status' => 202, 'data' => [], 'message' => "El usuario ya existe"]);
        }
        //var_dump($res);
    }
}
