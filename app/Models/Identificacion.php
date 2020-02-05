<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Identificacion extends Model
{
    protected $table = 'identificacion';

    public $timestamps = false;

    public static function getIdentificacionPersona($nro_doc,$tipo_doc){
        return DB::table('identificacion')
                ->where('id_tipo_identificacion',$tipo_doc)
                ->where('nroidentificacion',$nro_doc)
                ->first();
    }
}