<?php

namespace App\Services;

use App\Helpers\cURL;

class Sunat {
    var $cc;  // cUrl
    function __construct()
    {
        $this->cc = new cURL();
    }
    function getNumRand()
    {
        $url="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=random";
        $numRand = $this->cc->send($url);
        return $numRand;
    }
    function getDataRUC( $ruc )
    {
        $numRand = $this->getNumRand();
        $rtn = array();
        if($ruc != "" && $numRand!=false)
        {
            $data = array(
                "nroRuc" => $ruc,
                "accion" => "consPorRuc",
                "numRnd" => $numRand
            );

            $url = "http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias";
            $Page = $this->cc->send($url,$data);

            //RazonSocial
            $patron='/<input type="hidden" name="desRuc" value="(.*)">/';
            $output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
            if(isset($matches[0]))
            {
                $RS = utf8_encode(str_replace('"','', ($matches[0][1])));
                $rtn = array("RUC"=>$ruc,"RazonSocial"=>trim($RS));
            }

            //Telefono
            $patron='/<td class="bgn" colspan=1>Tel&eacute;fono\(s\):<\/td>[ ]*-->\r\n<!--\t[ ]*<td class="bg" colspan=1>(.*)<\/td>/';
            $output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
            if( isset($matches[0]) )
            {
                $rtn["Telefono"] = trim($matches[0][1]);
            }

            // Condicion Contribuyente
            $patron='/<td class="bgn"[ ]*colspan=1[ ]*>Condici&oacute;n del Contribuyente:[ ]*<\/td>\r\n[\t]*[ ]+<td class="bg" colspan=[1|3]+>[\r\n\t[ ]+]*(.*)[\r\n\t[ ]+]*<\/td>/';
            $output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
            if( isset($matches[0]) )
            {
                $rtn["Condicion"] = strip_tags(trim($matches[0][1]));
            }

            $busca=array(
                "NombreComercial" 		=> "Nombre Comercial",
                "Tipo" 					=> "Tipo Contribuyente",
                "Inscripcion" 			=> "Fecha de Inscripci&oacute;n",
                "Estado" 				=> "Estado del Contribuyente",
                "Direccion" 			=> "Direcci&oacute;n del Domicilio Fiscal",
                "SistemaEmision" 		=> "Sistema de Emisi&oacute;n de Comprobante",
                "ActividadExterior"		=> "Actividad de Comercio Exterior",
                "SistemaContabilidad" 	=> "Sistema de Contabilidad",
                "Oficio" 				=> "Profesi&oacute;n u Oficio",
                "ActividadEconomica" 	=> "Actividad\(es\) Econ&oacute;mica\(s\)",
                "EmisionElectronica" 	=> "Emisor electr&oacute;nico desde",
                "PLE" 					=> "Afiliado al PLE desde"
            );
            foreach($busca as $i=>$v)
            {
                $patron='/<td class="bgn"[ ]*colspan=1[ ]*>'.$v.':[ ]*<\/td>\r\n[\t]*[ ]+<td class="bg" colspan=[1|3]+>(.*)<\/td>/';
                $output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
                if(isset($matches[0]))
                {
                    $rtn[$i] = trim(utf8_encode( preg_replace( "[\s+]"," ", ($matches[0][1]) ) ) );
                }
            }
        }
        if( count($rtn) > 2 )
        {
            return $rtn;
        }
        return false;
    }
}