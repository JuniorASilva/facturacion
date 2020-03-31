<?php

namespace App\Extras;

/**
 * Llamo a clases de la libreria Greenter
 */
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\See;

use Greenter\Ws\Services\SunatEndpoints;
use Greenter\XMLSecLibs\Certificate\X509Certificate;
use Greenter\XMLSecLibs\Certificate\X509ContentType;

class Facturacion
{
    /**
     * Propiedad cliente
     *
     * @var Client
     */
    private $cliente;

    /**
     * Propiedad de los datos de mi empresa
     *
     * @var Company
     */
    private $empresa;

    /**
     * Propiedad de mi direccion como empresa
     *
     * @var Address
     */
    private $direccion;

    /**
     * Todo el comprobante que estoy generando
     *
     * @var Invoice
     */
    private $comprobante;

    /**
     * Permite manejar el comprobante
     *
     * @var See
     */
    private $manejador;

    /**
     * Instancia DOM del xml
     * 
     * @var DOMDocument
     */
    private $domXml;

    /**
     * Status de envio a sunat
     *
     * @var int
     */
    private $statusSend;

    /**
     * Mensaje de respuesta de envio a sunat
     *
     * @var String
     */
    private $mensajeRespuesta;

    public function __construct(){
        $this->manejador = new See();
        $this->cliente = new Client();
        $this->empresa = new Company();
        $this->direccion = new Address();
        $this->comprobante = new Invoice();

        //Datos del emisor
        $this->direccion->setUbigueo(config('app.empresa.ubigeo'))
                    ->setDepartamento(config('app.empresa.departamento'))
                    ->setProvincia(config('app.empresa.provincia'))
                    ->setDistrito(config('app.empresa.distrito'))
                    ->setDireccion(config('app.empresa.direccion'));
        $this->empresa->setRuc(config('app.empresa.ruc'))
                    ->setRazonSocial(config('app.empresa.razon_social'))
                    ->setNombreComercial(config('app.empresa.razon_social'))
                    ->setAddress($this->direccion);
        $this->comprobante->setCompany($this->empresa);

        //Cargando los certificados digitales
        $this->manejador->setService(
            config('app.empresa.certificado.endpoint') == 'test' 
            ? SunatEndpoints::FE_BETA : 
            SunatEndpoints::FE_PRODUCCION
        );
        $user = config('app.empresa.ruc').config('app.empresa.usuario');
        $pass = config('app.empresa.password');
        $this->manejador->setCredentials($user,$pass);
        $this->cargaCertificado();
    }

    /**
     * Inserta al cliente en el comprobante
     *
     * @param array $cliente
     * @return void
     */
    public function setCliente($cliente = array()){
        $this->cliente->setTipoDoc($cliente['tipo_doc_cliente'])
                    ->setNumDoc($cliente['nro_identificacion'])
                    ->setRznSocial($cliente['nombres']);
        $this->comprobante->setClient($this->cliente);
    }

    /**
     * Inserta todo el cuerpo del comprobante
     *
     * @param array $data
     * @return void
     */
    public function setInvoice($data = array()){
        $this->comprobante->setUblVersion('2.1')
                        ->setTipoOperacion('0101') // Catalog. 51
                        ->setTipoDoc($data['cod_doc'])
                        ->setSerie($data['num_serie'])
                        ->setCorrelativo($data['num_documento'])
                        ->setFechaEmision(new \DateTime())
                        ->setTipoMoneda('PEN')
                        ->setMtoOperGravadas($data['gravada'])
                        ->setMtoIGV($data['valorigv'])
                        ->setTotalImpuestos($data['valorigv'])
                        ->setValorVenta($data['gravada'])
                        ->setSubTotal($data['total'])
                        ->setMtoImpVenta($data['total']);
        //$this->comprobante->setLegends();
    }

    /**
     * Inserta todos los items al comprobante
     *
     * @param array $items
     * @return void
     */
    public function setItems($items = array()){
        $sales = [];
        foreach($items as $item){
            //el error de todos cambiar items por item
            $sale = new SaleDetail();
            $sale->setCodProducto('P001')
                ->setUnidad('NIU')
                ->setCantidad($item['quantity'])
                ->setDescripcion($item['name'])
                ->setMtoBaseIgv($item['quantity']*($item['price'] - $item['price']*0.18))
                ->setPorcentajeIgv(18.00) // 18%
                ->setIgv($item['price']*0.18)
                ->setTipAfeIgv($item['attributes']['tipo_igv']*10)
                ->setTotalImpuestos($item['price']*0.18)
                ->setMtoValorVenta($item['quantity']*($item['price'] - $item['price']*0.18))
                ->setMtoValorUnitario($item['price'] - $item['price']*0.18)
                ->setMtoPrecioUnitario($item['price']);
            array_push($sales,$sale);
        }
        $this->comprobante->setDetails($sales);
    }

    /**
     * Firma y guarda el archivo xml
     *
     * @return void
     */
    public function end(){
        $xml = $this->manejador->getXmlSigned($this->comprobante);
        file_put_contents(app_path().'/../files/'.$this->comprobante->getName().'.xml', $xml);
        $result = $this->manejador->send($this->comprobante);
        if (!$result->isSuccess()) {
            ddd($result);
            $this->statusSend = 500;
            $this->mensajeRespuesta = $result->getError();
        }else{
            $this->statusSend = 200;
            $this->mensajeRespuesta = '';
            file_put_contents(app_path().'/../files/'.'R-'.$this->comprobante->getName().'.zip', $result->getCdrZip());
        }      

        $this->domXml = new \DOMDocument();
        $this->domXml->loadXML($xml);
        return $this->getResumenFirma();
    }

    /**
     * Cargar el certificado si no lo encuentra lo extrae del archivo comprado
     *
     * @return void
     */
    private function cargaCertificado(){
        if(!file_exists(app_path().'/../files/certificado.pem')){
            //cargo el certificado completo
            $pfx = file_get_contents(app_path().'/../files/'.config('app.empresa.certificado.directory'));
            $password = config('app.empresa.certificado.pin');
            $certificate = new X509Certificate($pfx, $password);
            //extraccion de certificado publico
            $pem = $certificate->export(X509ContentType::PEM);
            file_put_contents(app_path().'/../files/certificado.pem', $pem);
        }
        $this->manejador->setCertificate(file_get_contents(app_path().'/../files/certificado.pem'));
    }

    /**
     * Retorno de datos resumen del xml
     *
     * @return array
     */
    public function getResumenFirma(){
        $digestValue = $this->domXml->getElementsByTagName('DigestValue');
        $signatureValue = $this->domXml->getElementsByTagName('SignatureValue');
        $datos = array(
            'DigestValue'       => $digestValue[0]->nodeValue,
            'SignatureValue'    => $signatureValue[0]->nodeValue
        );
        return $datos;
    }

    public function createPdf(){
        
    }

    /**
     * Retorna el estado
     *
     * @return void
     */
    public function getStatusSend(){
        return $this->statusSend;
    }

    /**
     * Retorna el mensaje de resputa
     *
     * @return void
     */
    public function getMensajeRespuesta(){
        return $this->mensajeRespuesta;
    }
}
