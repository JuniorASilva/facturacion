<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Identificacion extends Model
{
    protected $table = 'identificacion';
    public $timestamps = false;


    public static function getIdentificacionPersona($data){
        return Identificacion::where('id_tipo_identificacion','=',$data["tipo_identificacion"])
                        ->where('nroidentificacion','=',$data["nro_identificacion"])
                        ->first();
    }

}
