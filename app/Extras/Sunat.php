<?php

namespace App\Extras;

class Sunat{
    private $client;
    private $response;
    //captcha
    private $numRand;

    public function __construct(){
        $this->client = new \App\Extras\Curl();
        $this->client->load_params('http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=random');
        $this->numRand = $this->client->exec();
        $this->client = new \App\Extras\Curl();
    }

    public function llamado($ruc = ''){
        if($ruc == '')
            return false;
        $data = [
            'nroRuc'        => $ruc,
            'accion'        => 'consPorRuc',
            'numRnd'        => $this->numRand
        ];
        $this->client->load_params('http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias');
        $this->client->setPost($data);
        $this->response = $this->client->exec();
    }

    public function getData(){

            $data = [];

        $patron='/<input type="hidden" name="desRuc" value="(.*)">/';
        preg_match_all($patron,$this->response,$matches,PREG_SET_ORDER);

        if(isset($matches[0])){
            $rs = utf8_encode(str_replace('"','',($matches[0][1])));
            $data['razon_social'] = trim($rs);
        }

        //Telefono
        $patron='/<td class="bgn" colspan=1>Tel&eacute;fono\(s\):<\/td>[ ]*-->\r\n<!--\t[ ]*<td class="bg" colspan=1>(.*)<\/td>/';
        $output = preg_match_all($patron, $this->response, $matches, PREG_SET_ORDER);
        if( isset($matches[0]) )
        {
            $data["telefono"] = trim($matches[0][1]);
        }
        // Condicion Contribuyente
        $patron='/<td class="bgn"[ ]*colspan=1[ ]*>Condici&oacute;n del Contribuyente:[ ]*<\/td>\r\n[\t]*[ ]+<td class="bg" colspan=[1|3]+>[\r\n\t[ ]+]*(.*)[\r\n\t[ ]+]*<\/td>/';
        $output = preg_match_all($patron, $this->response, $matches, PREG_SET_ORDER);
        if( isset($matches[0]) )
        {
            $data["condicion"] = strip_tags(trim($matches[0][1]));
        }
        $busca=array(
            "nombre_comercial" 		=> "Nombre Comercial",
            "tipo" 					=> "Tipo Contribuyente",
            "inscripcion" 			=> "Fecha de Inscripci&oacute;n",
            "estado" 				=> "Estado del Contribuyente",
            "direccion" 			=> "Direcci&oacute;n del Domicilio Fiscal",
            "sistema_emision" 		=> "Sistema de Emisi&oacute;n de Comprobante",
            "actividad_exterior"		=> "Actividad de Comercio Exterior",
            "sistema_contabilidad" 	=> "Sistema de Contabilidad",
            "oficio" 				=> "Profesi&oacute;n u Oficio",
            "actividad_economica" 	=> "Actividad\(es\) Econ&oacute;mica\(s\)",
            "emision_electronica" 	=> "Emisor electr&oacute;nico desde",
            "ple" 					=> "Afiliado al PLE desde"
        );
        foreach($busca as $i=>$v)
        {
            $patron='/<td class="bgn"[ ]*colspan=1[ ]*>'.$v.':[ ]*<\/td>\r\n[\t]*[ ]+<td class="bg" colspan=[1|3]+>(.*)<\/td>/';
            $output = preg_match_all($patron, $this->response, $matches, PREG_SET_ORDER);
            if(isset($matches[0]))
            {
                $data[$i] = trim(utf8_encode( preg_replace( "[\s+]"," ", ($matches[0][1]) ) ) );
            }
        }
        if(count($data)>2){
            return $data;
        }
        return false;
    }
}