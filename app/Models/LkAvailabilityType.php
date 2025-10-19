<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LkAvailabilityType extends Model
{
    protected $table = 'lk_availability_type';
    protected $primaryKey = 'availabilityTypeID';
    public $timestamps = false;

    protected $fillable = ['availabilityTypeName'];

    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    public static function attributeLabels(): array
    {
        return [
            'availabilityTypeID' => 'Availability Type ID',
            'availabilityTypeName' => 'Availability Type Name',
        ];
    }
}
