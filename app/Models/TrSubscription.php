<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrSubscription extends Model
{
    use HasFactory;

    protected $table = 'tr_subscription';

    protected $fillable = [
        'email',
        'status',
        'subscribedDate',
        'unsubscribedDate',
    ];

    protected $casts = [
        'subscribedDate' => 'datetime',
        'unsubscribedDate' => 'datetime',
    ];
}
