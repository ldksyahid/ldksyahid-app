<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopupMessage extends Model
{
    protected $table      = 'tr_popupmessage';
    protected $primaryKey = 'messageID';
    public    $timestamps = false;

    protected $fillable = [
        'senderName',
        'messageText',
    ];

    protected $casts = [
        'messageID'   => 'integer',
        'createdDate' => 'datetime',
    ];
}
