<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratCounter extends Model
{
    protected $fillable = [
        'jenis_surat',
        'periode',
        'counter',
    ];
}