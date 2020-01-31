<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacturacionController extends Controller
{
    public function cargaDocumentos(Recuest $recuest){
        if (!$request->session()->has('user'))
            return redirect('/');
        
            if($recuest -> isMethod('post')){}
            else{
                return response()->json(['status'=>202,'data'=>[],'message'=>'Error, consulte con su administador']);
            }

    }
}
