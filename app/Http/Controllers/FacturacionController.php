<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utils;
use App\Models\Persona;
use App\Models\Empresa;
use App\Models\Identificacion;
use App\Extras\Sunat;

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

    public function consultaAutocompleteCliente(Request $request){
        if (!$request->session()->has('user'))
            return redirect('/');
        if(!$request -> isMethod('post')){
            return response()->json(['status'=>202,'data'=>[],'message'=>'Error, consulte con su administador']);
        }
        $where = $this->_preparaWhere($request->input('cod_doc'),$request->input('cliente'));
        if($request->input('cod_doc') == '03'){
            $clientes = (new Persona())->getClienteAutocomplete($where);
        }else{
            $clientes = (new Empresa())->getClienteAutocomplete($where);
        }
        $clients = array();

        if(!is_null($clientes)){
            foreach($clientes as $client)
            {
                array_push($clients,array('value'=>$client->nroidentificacion.'-'.$client->cliente,
                                    'data'=>$client));
            }
        }

        return response()->json(['suggestions'=>$clients]);
    }

    public function _preparaWhere($cod_doc,$cliente = ''){
        if(is_numeric($cliente)){
            $where=[
                ['i.nroidentificacion','like',$cliente.'%']
            ];
        }else{
            if($cod_doc == '03'){
                $where = [
                    ['p.apellidos','like',$cliente.'%']
                ];
            }else{
                $where = [
                    ['e.razon_social','like',$cliente.'%']
                ];
            }
        }
        return $where;
    }

    public function consultaRuc(Request $request){
        $ruc = $request->input('ruc');
        $sunat = new Sunat();
        $sunat->llamado($ruc);
        $data = $sunat->getData();
        if($data){
            $data['ruc'] = $ruc;
            $emp = new Empresa();
            $emp->razon_social = $data['razon_social'];
            $emp->nombre_comercial = $data['nombre_comercial'];
            $emp->direccion = $data['direccion'];
            $emp->estado = 1;
            if($emp->save()){
                $ident = new Identificacion();
                $ident->id_persona = 1;
                $ident->id_tipo_identificacion = 6;
                $ident->nroidentificacion = $data['ruc'];
                $ident->id_empresa = $emp->id;
                $ident->save();
                $data['id_empresa'] = $emp->id;
            }else{
                return response()->json(['status'=>202,'data'=>[],'message'=>'Error al almacenar los datos']);
            }
            return response()->json(['status'=>200, 'data' => $data, 'message' => 'Datos encontrado']);
        }
        return response()->json(['status'=>202, 'data' => [], 'message' => 'Datos no encontrados']);

    }

}
