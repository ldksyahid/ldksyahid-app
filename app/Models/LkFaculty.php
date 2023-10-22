<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkFaculty extends Model
{
    use HasFactory;

    protected $table = 'lk_faculty';

    protected $fillable = [
        'facultyName',
    ];

    public function getKtaData()
    {
        return $this->hasMany(MsKTALDKSyahid::class, 'facultyID', 'id');
    }
}
