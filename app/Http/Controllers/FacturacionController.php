<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Utils;
use App\Models\Usuario;
use App\Models\Persona;
use App\Models\Identificacion;
class FacturacionController extends Controller
{
    //
    public function crearCliente(Request $request){
    	if(!$request->session()->has('user'))
			return redirect('/');
		$i = Identificacion::getIdentificacionPersona($request->input('nro_doc'),$request->input('tipo_doc'));
		if(!is_null($i)){
			
			return response()->json(['status'=>202,'data'=>[],'message'=>'Ya existe el numero de documento']);
		}else{
			$p = new Persona();
			$p->nombres = $request->input('nombres');
	    	$p->apellidos = $request->input('apellidos');
	    	$p->direccion = '';
	    	$p->fch_nac = date('Y-m-d');
	    	$p->telefono = '123456789';
	    	$p->genero =1;
	    	$p->estado=1;
	    	$p->save();
	        $id_persona = $p->id;
	        $identificacion = new Identificacion();
	        $identificacion->nroidentificacion = $request ->input('nro-doc');
	        $identificacion->id_tipo_identificacion = $request->input('tipo_doc');
	        $identificacion->id_empresa = 1;
	        $identificacion->id_persona = $p->id;
	        $identificacion->save();
		}
		$data = $request->all();
		$data['id_persona'] = $id_persona;
		return response()->json(['status'=>200,'data'=>$data,'message'=>'Registro satisfaccion']);
        
        
    }

    public function cargaDocumentos(request $request){
    	if(!$request->session()->has('user'))
    		return redirect('/');
    	if($request->isMethod('post')){
    		$documentos =  (new Utils())->getDocumentos();
    		return response()->json(['status'=>200,'data'=>$documentos,'message'=>'Exito']);
    	}
    	else{
    		return response()->json_encode(['status' => 202, 'data' =>[],'message'=> 'Error']);
    	}
    }
}
