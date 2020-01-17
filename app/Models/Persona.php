<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Utils;
use App\Models\Persona;

class Persona extends Model
{
    protected $table = 'persona';
    public $timestamps = false;

    public function getPersonaWhereLike() {
        return $this->join('nombres','like','%'.$where['nombre'].'%')
                    ->join('apellidos','like','%'.$where['apellidos'].'%')
                    ->first();
    }

}
