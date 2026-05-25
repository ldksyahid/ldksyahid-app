<?php

namespace App\Models\forms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MsFormField extends Model
{
    protected $table      = 'ms_form_field';
    protected $primaryKey = 'formFieldID';
    public    $timestamps = false;

    protected $fillable = [
        'formID',
        'formSectionID',
        'fieldType',
        'label',
        'placeholder',
        'helpText',
        'isRequired',
        'isSystemField',
        'sortOrder',
        'options',
        'validation',
        'defaultValue',
        'conditionalLogic',
        'fieldConfig',
        'flagActive',
        'createdDate',
        'editedDate',
    ];

    protected $casts = [
        'isRequired'       => 'boolean',
        'isSystemField'    => 'boolean',
        'flagActive'       => 'boolean',
        'options'          => 'array',
        'validation'       => 'array',
        'conditionalLogic' => 'array',
        'fieldConfig'      => 'array',
        'createdDate'      => 'datetime',
        'editedDate'       => 'datetime',
    ];

    // -------------------------------------------------------------------------
    // Field type groups — used for validation and rendering logic
    // -------------------------------------------------------------------------

    public const TYPE_TEXT_FIELDS    = ['short_text', 'long_text', 'email', 'number', 'phone', 'url'];
    public const TYPE_DATE_FIELDS    = ['date', 'time', 'datetime'];
    public const TYPE_CHOICE_FIELDS  = ['dropdown', 'radio', 'checkbox'];
    public const TYPE_FILE_FIELDS    = ['file'];
    public const TYPE_DISPLAY_FIELDS = ['section_break', 'paragraph', 'image', 'header_image'];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function form()
    {
        return $this->belongsTo(MsForm::class, 'formID', 'formID');
    }

    public function section()
    {
        return $this->belongsTo(MsFormSection::class, 'formSectionID', 'formSectionID');
    }

    public function files()
    {
        return $this->hasMany(TrFormFile::class, 'formFieldID', 'formFieldID');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('flagActive', true);
    }

    public function scopeFileFields($query)
    {
        return $query->whereIn('fieldType', self::TYPE_FILE_FIELDS);
    }

    public function scopeInputFields($query)
    {
        // Returns only fields that collect user input (excludes display-only types)
        return $query->whereNotIn('fieldType', self::TYPE_DISPLAY_FIELDS);
    }

    // -------------------------------------------------------------------------
    // Business Logic
    // -------------------------------------------------------------------------

    /**
     * Whether this field type expects a file upload.
     */
    public function isFileUpload(): bool
    {
        return in_array($this->fieldType, self::TYPE_FILE_FIELDS);
    }

    /**
     * Whether this field is a display-only element (no user input).
     */
    public function isDisplayOnly(): bool
    {
        return in_array($this->fieldType, self::TYPE_DISPLAY_FIELDS);
    }

    /**
     * Build the Laravel validation rule string for this field.
     * Used by DynamicFormController when validating a form submission.
     */
    public function buildValidationRules(): array
    {
        $rules = [];

        if ($this->isDisplayOnly()) {
            return $rules;
        }

        // Required / nullable
        $rules[] = $this->isRequired ? 'required' : 'nullable';

        // Type-specific base rules
        switch ($this->fieldType) {
            case 'email':
                $rules[] = 'email';
                $rules[] = 'max:255';
                break;

            case 'number':
                $rules[] = 'numeric';
                break;

            case 'url':
                $rules[] = 'url';
                break;

            case 'date':
                $rules[] = 'date';
                break;

            case 'file':
            case 'image':
                $rules[] = 'file';
                break;
        }

        // Validation JSON overrides
        $v = $this->validation ?? [];

        if (!empty($v['min'])) {
            $rules[] = in_array($this->fieldType, ['file', 'image'])
                ? 'min:' . $v['min']
                : 'min:' . $v['min'];
        }

        if (!empty($v['max'])) {
            $rules[] = 'max:' . $v['max'];
        }

        if (!empty($v['maxSizeKB']) && $this->isFileUpload()) {
            // Laravel uses kilobytes for max file size
            $rules[] = 'max:' . $v['maxSizeKB'];
        }

        if (!empty($v['acceptedTypes']) && $this->isFileUpload()) {
            $rules[] = 'mimes:' . implode(',', (array) $v['acceptedTypes']);
        }

        if (!empty($v['pattern'])) {
            $rules[] = 'regex:/' . $v['pattern'] . '/';
        }

        return $rules;
    }

    /**
     * Retrieve the GDrive subfolder ID for this file field.
     * Stored in fieldConfig.gdriveFolderID during form setup.
     */
    public function getGdriveFolderID(): ?string
    {
        return $this->fieldConfig['gdriveFolderID'] ?? null;
    }

    /**
     * Create the system-mandated email field for a newly created form.
     * This field is auto-inserted at sort order 0 and cannot be deleted.
     */
    public static function createSystemEmailField(int $formID): self
    {
        return self::create([
            'formID'        => $formID,
            'formSectionID' => null,
            'fieldType'     => 'email',
            'label'         => 'Alamat Email',
            'placeholder'   => 'nama@contoh.com',
            'helpText'      => 'Email akan digunakan untuk mengirimkan konfirmasi pengisian formulir.',
            'isRequired'    => true,
            'isSystemField' => true,
            'sortOrder'     => 0,
            'options'       => null,
            'validation'    => ['rules' => ['required', 'email', 'max:255']],
            'defaultValue'  => null,
            'conditionalLogic' => null,
            'fieldConfig'   => null,
            'flagActive'    => true,
            'createdDate'   => Carbon::now(),
        ]);
    }
}
