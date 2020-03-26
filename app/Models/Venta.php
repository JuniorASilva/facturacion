<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Venta extends Model
{
    protected $table = 'tventa';

    public $timestamps = false;


    public function newVenta($data = array()){
        if(count($data) == 0)
            return false;
        return DB::select('CALL ingresaventa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', array_values($data));
    }

    public function newDetalleVenta($item = array()){
        DB::insert(`insert into tdetalleventa (num_serie, num_documento, cod_doc, id_producto, cantidad, precioventa, descuento, tipo_igv, igv, valor_igv, id_medida, cod_catalogo) 
                    values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`, array_values($item));
    }
}
