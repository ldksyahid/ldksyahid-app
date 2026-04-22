<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom untuk diisi, KECUALI kolom 'id'
    protected $guarded = ['id'];
    
    // (Opsional) Relasi ke pembuat surat
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // (Opsional) Relasi ke penyetuju surat
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}