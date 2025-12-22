<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkReport extends Model
{
    use HasFactory;

    protected $table = 'lk_report';
    protected $primaryKey = 'reportID';
    public $timestamps = false;

    protected $fillable = [
        'reportName',
        'node',
        'description',
        'iconGdriveID',
        'createdDate',
        'editedDate',
    ];

    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    public static function attributeLabels(): array
    {
        return [
            'reportID' => 'Report ID',
            'reportName' => 'Report Name',
            'node' => 'Node',
            'description' => 'Description',
            'iconGdriveID' => 'Icon GDrive ID',
            'createdDate' => 'Created Date',
            'editedDate' => 'Edited Date',
        ];
    }
}
