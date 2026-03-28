<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrVisitorLog extends Model
{
    use HasFactory;

    protected $table      = 'tr_visitor_log';
    protected $primaryKey = 'ID';
    public    $timestamps = false;

    protected $fillable = [
        'ipAddress',
        'ipHash',
        'path',
        'queryString',
        'referer',
        'userAgent',
        'deviceType',
        'browser',
        'os',
        'isUniqueDaily',
        'isBot',
        'visitedAt',
    ];

    protected $casts = [
        'isUniqueDaily' => 'boolean',
        'isBot'         => 'boolean',
        'visitedAt'     => 'datetime',
    ];

    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    public static function attributeLabels(): array
    {
        return [
            'ID'            => 'ID',
            'ipAddress'     => 'IP Address',
            'ipHash'        => 'IP Hash',
            'path'          => 'Path',
            'queryString'   => 'Query String',
            'referer'       => 'Referer',
            'userAgent'     => 'User Agent',
            'deviceType'    => 'Device Type',
            'browser'       => 'Browser',
            'os'            => 'OS',
            'isUniqueDaily' => 'Unique Daily',
            'isBot'         => 'Is Bot',
            'visitedAt'     => 'Visited At',
        ];
    }
}
