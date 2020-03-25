<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Utils;
use App\Models\Persona;
use App\Models\Empresa;
use App\Models\Identificacion;

class FacturacionController extends Controller
{

    public function crearCliente(Request $request){
        if(!$request->session()->has('user'))
            return redirect('/');
        $i = Identificacion::getIdentificacionPersona($request->input('nro_doc'),$request->input('tipo_doc'));
        if(!is_null($i)){
            //$id_persona = $i->id_persona;
            return response()->json(['status'=>202,'data'=>[],'message'=>'Ya existe registro con ese número de documento']);
        }else{
            $p = new Persona();
            $p->nombres = $request->input('nombres');
            $p->apellidos = $request->input('apellidos');
            $p->direccion = '';
            $p->fch_nac = date('Y-m-d');
            $p->telefono = '12345679';
            $p->genero = 1;
            $p->estado = 1;
            $p->save();
            $id_persona = $p->id;
            $identificacion = new Identificacion();
            $identificacion->nroidentificacion = $request->input('nro_doc');
            $identificacion->id_tipo_identificacion = $request->input('tipo_doc');
            $identificacion->id_empresa = 1;
            $identificacion->id_persona = $p->id;
            $identificacion->save();
        }
        $data = $request->all();
        $data['id_persona'] = $id_persona;
        return response()->json(['status'=>200,'data'=>$data,'message'=>'Registro satisfactorio']);
    }

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

    public function consultaAutocompleteCliente(Request $request){
        if(!$request->session()->has('user'))
            return redirect('/');
        if(!$request->isMethod('post'))
            return response()->json(['status'=>202,'data'=>[],'message'=>'Error consulte con su administrador']);

        $where = $this->_preparaWhere($request->input('cod_doc'),$request->input('cliente'));
        if($request->input('cod_doc') == '03')
            $clientes = (new Persona())->getClienteAutocomplete($where);
        else
            $clientes = (new Empresa())->getClienteAutocomplete($where);
        $clients = array();
        if(!is_null($clientes)){
            foreach($clientes as $client){
                array_push($clients,array(
                    'value'=>$client->nroidentificacion.' - '.$client->cliente,
                    'data'=>$client
                    )
                );
            }
        }
        return \Response::json(array('suggestions'=>$clients));
    }

    public function _preparaWhere($cod_doc,$cliente = ''){
        if(is_numeric($cliente)){
            $where= [
                ['i.nroidentificacion','like',$cliente.'%']
            ];
        }else{
            if($cod_doc == '03')
                $where = [
                    ['p.apellidos','like',$cliente.'%']
                ];
            else
                $where = [
                    ['e.razon_social','like',$cliente.'%']
                ];
        }
        return $where;
    }

    public function consultaRuc(Request $request){
        $sunat = new \App\Extras\Sunat();
        $sunat->llamado($request->input('ruc'));
        $data = $sunat->getData();
        if($data){
            $data['ruc'] = $request->input('ruc');
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
            return response()->json(['status'=>200,'data'=>$data,'message'=>'Datos encontrados']);
        }
        return response()->json(['status'=>202,'data'=>[],'message'=>'Datos no encontrados']);
    }

    public function agregaItem(Request $request){
        \Cart::session($request->session()->getId());

        $item = [
            'id'=> sha1($request->input('descripcion')),
            'name'=>$request->input('descripcion'),
            'price'=>$request->input('precio'),
            'quantity'=>$request->input('cantidad'),
            'attributes'=> [
                'tipo_igv'=>$request->input('igv'),
                'tipo'=>$request->input('tipoitem'),
                'descuento'=>$request->input('descuento')
                ]
            ];
        \Cart::add($item);
        return response()->json(['status'=>200,'data'=>$item,'message'=>'Item Agregado']);

    }

    public function generaVenta(Request $request){
        if(!$request->isMethod('post'))
        {
            return redirect('/nueva-venta');
        }
    }
}
