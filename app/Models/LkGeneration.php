<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LkGeneration extends Model
{
    protected $table = 'lk_generation';

    protected $fillable = [
        'year',
        'generationName',
    ];

    public $timestamps = false;

    public function getKtaData()
    {
        return $this->hasMany(MsKTALDKSyahid::class, 'generationID', 'id');
    }
}
