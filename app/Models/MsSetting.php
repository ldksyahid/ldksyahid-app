<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsSetting extends Model
{

    protected $table = 'ms_setting';

    // Mass assignable attributes
    protected $fillable = [
        'key1',
        'key2',
        'value1',
        'value2',
    ];

    // Attribute casting
    protected $casts = [
        'key1' => 'string',
        'key2' => 'string',
        'value1' => 'string',
        'value2' => 'string',
    ];

    // =========================
    // Type Constants
    // =========================
    public const TYPE_STRING = 'string';
    public const TYPE_INT    = 'int';
    public const TYPE_BOOL   = 'bool';
    public const TYPE_FLOAT  = 'float';

    /**
     * Get the table name for the model
     */
    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    /**
     * Get attribute labels for forms and displays
     */
    public static function attributeLabels(): array
    {
        return [
            'key1' => 'Key 1',
            'key2' => 'Key 2',
            'value1' => 'Value 1',
            'value2' => 'Value 2',
        ];
    }

    /**
     * Get setting value by key1 and key2 with dynamic return type casting.
     *
     * This method retrieves value1 from ms_setting table
     * and converts it based on the given $type constant.
     *
     * Available type constants:
     * - self::TYPE_STRING
     * - self::TYPE_INT
     * - self::TYPE_BOOL
     * - self::TYPE_FLOAT
     *
     * Example usage:
     *
     * ```php
     * // Return as string
     * $appName = MsSetting::getSettingValue1('APP', 'NAME', MsSetting::TYPE_STRING);
     *
     * // Return as integer
     * $limit = MsSetting::getSettingValue1('APP', 'LIMIT', MsSetting::TYPE_INT);
     *
     * // Return as boolean
     * $isActive = MsSetting::getSettingValue1('APP', 'ACTIVE', MsSetting::TYPE_BOOL);
     *
     * // Return as float
     * $rate = MsSetting::getSettingValue1('APP', 'RATE', MsSetting::TYPE_FLOAT);
     * ```
     *
     * @param string $key1
     * @param string $key2
     * @param string $type Use class constant (default: TYPE_STRING)
     *
     * @return string|int|bool|float|null
     */
    public static function getSettingValue1($key1, $key2, $type = self::TYPE_STRING)
    {
        $model = self::where([
            'key1' => $key1,
            'key2' => $key2
        ])->first();

        if (empty($model)) {
            return null;
        }

        $value = $model->value1;

        switch ($type) {
            case self::TYPE_INT:
                return (int) $value;

            case self::TYPE_BOOL:
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);

            case self::TYPE_FLOAT:
                return (float) $value;

            case self::TYPE_STRING:
            default:
                return (string) $value;
        }
    }

    /**
     * Get setting value2 by key1 and key2 with dynamic return type casting.
     *
     * This method retrieves value2 from ms_setting table
     * and converts it based on the given $type constant.
     *
     * @param string $key1
     * @param string $key2
     * @param string $type Use class constant (default: TYPE_STRING)
     *
     * @return string|int|bool|float|null
     */
    public static function getSettingValue2($key1, $key2, $type = self::TYPE_STRING)
    {
        $model = self::where([
            'key1' => $key1,
            'key2' => $key2
        ])->first();

        if (empty($model)) {
            return null;
        }

        $value = $model->value2;

        switch ($type) {
            case self::TYPE_INT:
                return (int) $value;

            case self::TYPE_BOOL:
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);

            case self::TYPE_FLOAT:
                return (float) $value;

            case self::TYPE_STRING:
            default:
                return (string) $value;
        }
    }
}
