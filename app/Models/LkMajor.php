<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LkMajor extends Model
{
    protected $table = 'lk_major';

    protected $fillable = [
        'facultyID',
        'majorName',
    ];

    public $timestamps = false;

    public function getKtaData()
    {
        return $this->hasMany(MsKTALDKSyahid::class, 'majorID', 'id');
    }
}
