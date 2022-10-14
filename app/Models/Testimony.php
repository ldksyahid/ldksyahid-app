<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Testimony extends Model
{
    use HasFactory;
    protected $guarded =[];

    public static function getAPITestimony()
    {
        $return=DB::table('testimonies');
        return $return;
    }
}
