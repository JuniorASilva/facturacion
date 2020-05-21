<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = 'tdetalleventa';

    public $timestamps = false;

    public function items()
    {
        $data1 = [1, 2, 3, 4];
        $data2 = [5, 6];

        return [...$data1, ...$data2];
    }
}
