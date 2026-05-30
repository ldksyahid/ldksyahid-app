<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrVisitorDailyUnique extends Model
{
    use HasFactory;

    protected $table      = 'tr_visitor_daily_unique';
    protected $primaryKey = 'ID';
    public    $timestamps = false;

    protected $fillable = [
        'ipHash',
        'visitDate',
        'visitCount',
        'firstPath',
        'createdDate',
        'updatedDate',
    ];

    protected $casts = [
        'visitDate'   => 'date',
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
            'ID'          => 'ID',
            'ipHash'      => 'IP Hash',
            'visitDate'   => 'Visit Date',
            'visitCount'  => 'Visit Count',
            'firstPath'   => 'First Path',
            'createdDate' => 'Created Date',
            'updatedDate' => 'Updated Date',
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
