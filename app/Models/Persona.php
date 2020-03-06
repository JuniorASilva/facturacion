<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Persona extends Model
{
    protected $table = 'persona';

    public $timestamps = false;


    public function getPersonaWhereLike($where = array())
    {
        return $this->where('nombres', 'like', '%' . $where['nombres'] . '%')
                    ->where('apellidos', 'like', '%' . $where['apellidos'] . '%')
                    ->first();
    }

    public static function updatePersona($data = array(), $where = array())
    {
        return self::where('id', $where['id'])
                    ->update($data);
    }

    public static function getClienteAutocomplete($where)
    {
        return DB::table('persona as p')
                 ->select(DB::raw('CONCAT(p.apellidos, " ",p.nombres) AS cliente'), 'p.id as id_cliente', 'i.nroidentificacion')
                 ->join('identificacion as i', 'p.id', '=', 'i.id_persona')
                 ->where('i.id_tipo_identificacion', 2)
                 ->where($where)
                 ->get();
    }
}
