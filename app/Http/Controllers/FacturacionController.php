<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Models\Utils;
use App\Models\Persona;
use App\Models\Identificacion;
use Carbon\Carbon;

class FacturacionController extends Controller
{
    public function cargaDocumentos(Request $request){
        if (!$request->session()->has('user'))
            return redirect('/');
        if($request->isMethod('post')){
            $documentos = (new Utils())->getDocumentos();
            return response()->json(['status' => 200, 'data' => $documentos, 'message' => '']);
        }else{
            return response()->json(['status' => 202, 'data' => [], 'message' => 'Error, consulte con su administrador']);
        }
    }

    public function crearCliente(Request $request){
        if (!$request->session()->has('user'))
            return redirect('/');

        if ($request->isMethod('post')) {
            $datos = array(
                "tipo_identificacion" => $request->input('tipo_doc'),
                "nro_identificacion" => $request->input('nro_doc')
            );
            $i = Identificacion::getIdentificacionPersona($datos);
            if(!is_null($i)){
                //$id_persona = $i->id_persona;
                return response()->json(['status' => 202, 'data' => [], 'message' => 'Ya existe el documento']);
            }else{
                $p = new Persona();
                $p->nombres = $request->input('nombres');
                $p->apellidos = $request->input('apellidos');
                $p->direccion = $request->input('direccion');
                $p->fch_nac = Carbon::parse($request->input('fch_nac'))->isoFormat('Y-M-D');
                $p->telefono = $request->input('telefono');
                $p->genero = $request->input('cb_genero');
                $p->estado = 1;
                $p->save();
                $id_persona = $p->id;
                $identificacion = new Identificacion();
                $identificacion->nroidentificacion = $datos["nro_identificacion"];
                $identificacion->id_tipo_identificacion = $datos["tipo_identificacion"];
                $identificacion->id_empresa = 1;
                $identificacion->id_persona = $id_persona;
                $identificacion->save();
            }
            $data = $request->all();
            $data["id_persona"] = $id_persona;
            return response()->json(['status' => 200, 'data' => $data, 'message' => 'Registro satisfactorio']);
        }
    }

    public function consultaAutocompleteCliente(Request $request){
        if (!$request->session()->has('user'))
        return redirect('/');

        if (!$request->isMethod('post'))
            return response()->json(['status'=>202,'data'=>[],'message'=>'Error consulte con su administrador']);
        
        if(is_numeric($request->input('cliente'))){
            $where = [['i.nroidentificacion','like',$request->input('cliente').'%']];
        }else{
            $where = [['p.apellidos','like',$request->input('cliente').'%']];
        }
        $personas = (new Persona())->getClienteAutocomplete($where);
        $pers = [];
        if(!is_null($personas)){
            foreach($personas as $per){
                array_push($pers, ['value' => $per->nroidentificacion.' - '.$per->apellidos.' '.$per->nombres,
                                    'data' => $per
                                  ]);
            }
        }
        return response()->json(['suggestions'=>$pers]);
    }

}