<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Venta extends Model
{
    protected $table = 'tventa';

    public $timestamps = false;

    protected function getComprobante($num_serie,$num_documento){
        return $this->where('num_serie',$num_serie)->where('num_documento',$num_documento)->first();
    }

    public function newVenta($data = array()){
        if(count($data) == 0)
            return false;
        return DB::select('CALL ingresaventa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', array_values($data));
    }
}
