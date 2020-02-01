<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Utils;

class FacturacionController extends Controller
{
    //

    public function cargaDocumentos(Request $request){
        if(!$request->session()->has('user'))
            return redirect('/');
        if($request->isMethod('post')){
            $documentos = (new Utils())->getDocumentos();
            return response()->json(['status'=>200,'data'=>$documentos,'message'=>'Consulta satisfactoria']);
        }
        else{
            return response()->json(['status'=>202,'data'=>[],'message'=>'Error consulte con su administrador']);
        }
    }
}
