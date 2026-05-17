<?php

namespace App\Models\forms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MsFormSetting extends Model
{
    protected $table      = 'ms_form_setting';
    protected $primaryKey = 'formSettingID';
    public    $timestamps = false;

    protected $fillable = [
        'formID',
        'settingKey',
        'settingValue',
        'settingType',
        'settingDescription',
        'createdDate',
        'editedDate',
    ];

    protected $casts = [
        'createdDate' => 'datetime',
        'editedDate'  => 'datetime',
    ];

    // -------------------------------------------------------------------------
    // Default setting keys
    // -------------------------------------------------------------------------

    public const KEY_RATE_LIMIT_PER_IP     = 'rate_limit_per_ip';
    public const KEY_RATE_LIMIT_WINDOW_MIN = 'rate_limit_window_minutes';
    public const KEY_SEND_CONFIRM_EMAIL    = 'send_confirmation_email';

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function form()
    {
        return $this->belongsTo(MsForm::class, 'formID', 'formID');
    }

    // -------------------------------------------------------------------------
    // Business Logic
    // -------------------------------------------------------------------------

    /**
     * Upsert a setting value for a form.
     */
    public static function upsert(int $formID, string $key, $value, string $type = 'string'): void
    {
        self::updateOrCreate(
            ['formID' => $formID, 'settingKey' => $key],
            [
                'settingValue' => is_array($value) ? json_encode($value) : (string) $value,
                'settingType'  => $type,
                'editedDate'   => Carbon::now(),
                'createdDate'  => Carbon::now(), // only used on insert
            ]
        );
    }

    /**
     * Seed default settings when a new form is created.
     */
    public static function seedDefaults(int $formID): void
    {
        $defaults = [
            [
                'key'         => self::KEY_RATE_LIMIT_PER_IP,
                'value'       => '5',
                'type'        => 'integer',
                'description' => 'Max submissions per IP address per window',
            ],
            [
                'key'         => self::KEY_RATE_LIMIT_WINDOW_MIN,
                'value'       => '10',
                'type'        => 'integer',
                'description' => 'Rate limit time window in minutes',
            ],
            [
                'key'         => self::KEY_SEND_CONFIRM_EMAIL,
                'value'       => '1',
                'type'        => 'boolean',
                'description' => 'Send a confirmation email to the respondent after submission',
            ],
        ];

        $now = Carbon::now();

        foreach ($defaults as $default) {
            self::firstOrCreate(
                ['formID' => $formID, 'settingKey' => $default['key']],
                [
                    'settingValue'       => $default['value'],
                    'settingType'        => $default['type'],
                    'settingDescription' => $default['description'],
                    'createdDate'        => $now,
                ]
            );
        }
    }
}
