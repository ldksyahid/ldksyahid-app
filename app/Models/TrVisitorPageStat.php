<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrVisitorPageStat extends Model
{
    use HasFactory;

    protected $table      = 'tr_visitor_page_stat';
    protected $primaryKey = 'ID';
    public    $timestamps = false;

    protected $fillable = [
        'statDate',
        'path',
        'totalHits',
        'uniqueVisitors',
        'mobileHits',
        'desktopHits',
        'tabletHits',
        'botHits',
        'createdDate',
        'updatedDate',
    ];

    protected $casts = [
        'statDate'    => 'date',
        'createdDate' => 'datetime',
        'updatedDate' => 'datetime',
    ];

    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    public static function attributeLabels(): array
    {
        return [
            'ID'             => 'ID',
            'statDate'       => 'Stat Date',
            'path'           => 'Path',
            'totalHits'      => 'Total Hits',
            'uniqueVisitors' => 'Unique Visitors',
            'mobileHits'     => 'Mobile Hits',
            'desktopHits'    => 'Desktop Hits',
            'tabletHits'     => 'Tablet Hits',
            'botHits'        => 'Bot Hits',
            'createdDate'    => 'Created Date',
            'updatedDate'    => 'Updated Date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->createdDate = now();
            $model->updatedDate = now();
        });

        static::updating(function ($model) {
            $model->updatedDate = now();
        });
    }
}
