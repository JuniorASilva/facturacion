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
}
