<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Venta extends Model
{
    protected $table = 'tventa';

    public $timestamps = false;

    public function newVenta($data = array())
    {
        if (count($data) == 0)
            return false;
        return DB::select('CALL ingresaventa(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', array_values($data));
    }
}
