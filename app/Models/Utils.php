<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Utils extends Model
{
    //
    public function getRoles(){
        return DB::table('trol')->get();
    }
}
