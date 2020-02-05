<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Identificacion extends Model
{
    protected $table = 'identificacion';
    
    public $timestamps = false;

    public static function getIdentificacionPersona($nro_doc,$tipodoc){
        return DB::table('identificacion')
        ->where('id_tipo_identificacion',$tipodoc)
        ->where('nroidentificacion',$nro_doc)
        ->first();
    }
}