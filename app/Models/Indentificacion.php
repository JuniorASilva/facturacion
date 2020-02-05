<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indentificacion extends Model
{
    protected $table = 'identificacion';

    public $timestamps = false;

    public static function getIdentificacionPersona($tipo_identificacion, $nro_documento)
    {
        return self::where('id_tipo_identificacion', $tipo_identificacion)
                    ->where('nroidentificacion', $nro_documento)
                    ->get();
    }
}
