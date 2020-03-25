<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Utils;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;

class Persona extends Model
{
    protected $table = 'persona';
    public $timestamps = false;

    public function getPersonaWhereLike($where = array()) {
        return $this->where('nombres','like','%'.$where['nombres'].'%')
                    ->where('apellidos','like','%'.$where['apellidos'].'%')
                    ->first();
    }

    public static function getIdentificacionWhere($nro_doc,$tipo_doc) {
        return DB::table('identificacion')
                    ->where('id_tipo_identificacion',$tipo_doc)
                    ->where('nroidentificacion',$nro_doc)
                    ->first();
    }



     public function updatePersona($data = array(), $where = array())
    {
        return $this->where('id',$where['id'])
                    ->update($data);
    }

    public function getClienteAutocomplete($where){
        return DB::table('persona as p')
                    ->join('identificacion as i', 'p.id', '=','i.id_persona')
                    ->where('i.id_tipo_identificacion',2)
                    ->where($where)
                    ->select(DB::raw('CONCAT(p.apellidos," ",p.nombres) as cliente'),'p.id as id_cliente','i.nroidentificacion')
                    ->get();

    }

}
