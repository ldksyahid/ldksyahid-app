<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkLDK extends Model
{
    use HasFactory;

    protected $table = 'lk_ldk';
    protected $primaryKey = 'ldkID';
    public $timestamps = false;

    protected $fillable = [
        'ldkTag',
        'ldkName',
        'logoGdriveID',
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
            'ldkID' => 'LDK ID',
            'ldkTag' => 'LDK Tag',
            'ldkName' => 'LDK Name',
            'logoGdriveID' => 'Logo GDrive ID',
            'createdDate' => 'Created Date',
            'editedDate' => 'Edited Date',
        ];
    }
}
