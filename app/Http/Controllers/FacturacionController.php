<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utils;
use App\Models\Persona;
use App\Models\Identificacion;

class FacturacionController extends Controller
{

    public function crearCliente(Request $request)
    {
        if (!$request->session()->has('user'))
            return redirect('/'); 

        $i = Identificacion::getIdentificacionWhere($request->input('nro_doc'),$request->input('tipo_doc'));
        if(!is_null($i))
        {
            $id_persona = $i->id_persona;
            return response()->json(['status'=>202,'data'=>[],'message'=>'Error, consulte con su administador']);
        }
        else{
            $p=new Persona();
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
            $identificacion->nroidentificacion = $request->input('nro_doc');
            $identificacion->id_tipo_identificacion = $request->input('tipo_doc');
            $identificacion->id_empresa=1;
            $identificacion->id_persona=$p->id;
            $identificacion->save();

        }
            
        $data = $request->All();
        $data['id_persona'] = $id_persona;
        return response()->json(['status'=>200,'data'=>$data,'message'=>'Se Registro Satisfactoriamente!!']);

    }

    

    public function cargaDocumentos(Request $request){
        if (!$request->session()->has('user'))
            return redirect('/');
        
            if($request -> isMethod('post')){
                $documentos=(new Utils())->getDocumentos();
                return response()->json(['status'=>200,'data'=>$documentos,'message'=>'Consulta Satisfactoria']);
            }
            else{
                return response()->json(['status'=>202,'data'=>[],'message'=>'Error, consulte con su administador']);
            }

    }
}
