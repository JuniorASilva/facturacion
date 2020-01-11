<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    //
    protected $table = 'tusuario';

    public function getUsuarioWhere($where = array()){
    	return $this->where($where)->first();
    }
}
