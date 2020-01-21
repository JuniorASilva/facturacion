<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'tusuario';

    public $timestamps = false;

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

    public static function saveUser($datos)
    {
        $user = new Usuario();
        $user->usuario = $datos['usuario'];
        $user->pass = $datos['pass'];
        $user->persona_id = $datos['persona'];
        $user->rol_id = $datos['rol'];
        $user->fch_caducidad_rol = Carbon::now();

        if ($user->save()) {
            return true;
        } else {
            return false;
        }
    }
}
