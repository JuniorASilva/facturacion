<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Utils;
use App\Models\Persona;

class Persona extends Model
{
    protected $table = 'persona';
    public $timestamps = false;

    public function getPersonaWhereLike($where = array()) {
        return $this->where('nombres','like','%'.$where['nombres'].'%')
                    ->where('apellidos','like','%'.$where['apellidos'].'%')
                    ->first();
    }

}
