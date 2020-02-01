<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Utils;

class FacturacionController extends Controller
{
    //
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
