<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Utils;
use App\Models\Persona;
use App\Models\Identificacion;

class FacturacionController extends Controller
{
    //
    public function crearCliente(Request $request){
        if (!$request->session()->has('user'))
            return redirect('/');
            $i = Identificacion::getIdentificacionPersona($request->input('nro_doc'),$request->input('tipo_doc'));
            if(!is_null($i) ){
                //$id_persona = $i->id_persona;
                return response()->json(['status'=>202,'data'=>[],'message'=>'Ya existe Registro Ingresado']);
            }else{
                $p = new Persona();
                $p->nombres = $request->input('nombres');
                $p->apellidos = $request->input('apellidos');
                $p->direccion = '';                        
                $p->fch_nac = date('Y-m-d');
                $p->telefono = '123456789';
                $p->genero = 1;
                $p->estado = 1;
                $p->save();
                $id_persona = $p->id;

                $identificacion = new Identificacion();
                $identificacion->nroidentificacion = $request->input('nro-doc');
                $identificacion->id_tipo_identificacion = $request->input('tipo-doc');
                $identificacion->id_empresa = 1;
                $identificacion->id_persona = $p->$id; 
                $identificacion->save();
            }   
            $data = $request->all();
            $data['id_persona'] = $id_persona;         
            return response()->json(['status'=>200,'data'=>$data,'message'=>'Registro Satisfactorio']);



       /* if ($request->isMethod('post')) {
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
                $p->direccion = $request->input('direccion');
                $p->tipodoc = $request->input('tipo_doc');
                $p->numdoc = $request->input('nro_doc');
                $p->fch_nac = date('Y-m-d');
                $p->telefono = '123456789';
                $p->genero = 1;
                $p->save();
            }

            $is_save_user = Usuario::saveUser([
                'usuario' => $request->input('usuario'),
                'pass' => md5(sha1($request->input('pass'))),
                'persona' => $p->id,
                'rol' => $request->input('roles'),
            ]);

            if ($is_save_user) {
                return response()->json([
                    'status'  => 200,
                    'data'    => [],
                    'message' => 'Registro satisfactorio'
                ]);
            } else {
                return response()->json([
                    'status'  => 200,
                    'data'    => [],
                    'message' => 'Ingrese datos correctamente'
                ]);
            }
        }

        $option = 'usuarios';
        $roles = (new Utils())->getRoles();

        return view('usuarios.nuevos', compact('option', 'roles'));*/
    }

    public function cargaDocumentos(Request $request){
        if (!$request->session()->has('user'))
            return redirect('/');

            if ($request->isMethod('post')){
                $documentos = (new Utils())->getDocumentos();
                return response()->json(['status'=>200,'data'=>$documentos,'message'=>'Consulta satisfactoria']);
            }
            else{
            return response()->json(['status'=>202,'data'=>[],'message'=>"Error consulte con su admnistrador"]);
            }
    }
}
