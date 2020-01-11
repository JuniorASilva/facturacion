<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'tusuario';

    public function getUsuarioWhere($where = array())
    {
        return $this->where($where)->first();
    }

    public function getAllUsuarios()
    {
        return $this->join('persona as tp', 'tusuario.persona_id', '=', 'tp.id')
                    ->join('trol as tr', 'tusuario.rol_id', '=', 'tr.id')
                    ->get();
    }
}
