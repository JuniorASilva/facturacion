<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Empresa extends Model
{
    protected $table = 'empresa';

    public $timestamps = false;

    public function getClienteAutocomplete($where){
        return DB::table('empresa as e')
                    ->join('identificacion as i', 'e.id', '=','i.id_persona')
                    ->where('i.id_tipo_identificacion', 6)
                    ->where($where)
                    ->select(DB::raw('e.razon_social as cliente'),'e.id as id_cliente','i.nroidentificacion')
                    ->get();

    }
}
