<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsKTALDKSyahid extends Model
{
    protected $table = 'ms_ktaldksyahid';

    protected $fillable = [
        'fullName',
        'nim',
        'faculty',
        'major',
        'generation',
        'about',
        'memberNumber',
        'linkProfile',
        'photo',
    ];
}
