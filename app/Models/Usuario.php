<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Usuario extends Model
{
    //
    protected $table = 'tusuario';
    public $timestamps = false;

    public function getUsuarioWhere($where = array()){
        return $this->where($where)->first();

    }

    public function getAllUsuarios()
    {
        return $this->join('persona as tp','tusuario.persona_id','=','tp.id')
                    ->join('trol as tr','tusuario.rol_id','=','tr.id')
                    ->select('tusuario.*','tp.nombres','tp.apellidos','tr.nombre as rol')
                    ->get();
    }
    

    public function getUsuariosById($id=0)
    {
        return $this->join('persona as tp','tusuario.persona_id','=','tp.id')
                    ->join('trol as tr','tusuario.rol_id','=','tr.id')
                    ->select('tusuario.*','tp.nombres','tp.apellidos','tr.nombre as rol')
                    ->where('tusuario.id',$id)
                    ->first();
    }

    static function saveUser($datos)
    {
        $user = new Usuario;
        $user->usuario = $datos["usuario"];
        $user->pass = $datos["clave"];
        $user->persona_id = $datos["persona_id"];
        $user->rol_id = $datos["rol"];
        $user->fch_caducidad_rol = Carbon::now();
        if ($user->save()) {
            return true;
        }
        else{
            return false;
        }
    }
}
