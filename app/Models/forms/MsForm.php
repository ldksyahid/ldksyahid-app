<?php

namespace App\Models\forms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class MsForm extends Model
{
    protected $table      = 'ms_form';
    protected $primaryKey = 'formID';
    public    $timestamps = false;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'version',
        'themeConfig',
        'headerImage',
        'headerImageGdriveID',
        'maxSubmission',
        'isMultipleSubmit',
        'requireLogin',
        'startDate',
        'endDate',
        'confirmationMessage',
        'redirectUrl',
        'notifyEmails',
        'collaboratorEmails',
        'gdriveFolderID',
        'gdriveSpreadsheetID',
        'gdriveSpreadsheetUrl',
        'gdriveAttachmentsFolderID',
        'gdriveAttachmentsFolderUrl',
        'totalSubmission',
        'flagActive',
        'createdBy',
        'createdDate',
        'editedBy',
        'editedDate',
    ];

    protected $casts = [
        'themeConfig'        => 'array',
        'notifyEmails'       => 'array',
        'collaboratorEmails' => 'array',
        'isMultipleSubmit'   => 'boolean',
        'requireLogin'       => 'boolean',
        'flagActive'         => 'boolean',
        'startDate'          => 'datetime',
        'endDate'            => 'datetime',
        'createdDate'        => 'datetime',
        'editedDate'         => 'datetime',
    ];

    // -------------------------------------------------------------------------
    // Allowed sort columns for admin index
    // -------------------------------------------------------------------------

    protected static array $allowedSorts = [
        'title',
        'status',
        'totalSubmission',
        'createdDate',
        'editedDate',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function fields()
    {
        return $this->hasMany(MsFormField::class, 'formID', 'formID')
                    ->orderBy('sortOrder');
    }

    public function activeFields()
    {
        return $this->hasMany(MsFormField::class, 'formID', 'formID')
                    ->where('flagActive', true)
                    ->orderBy('sortOrder');
    }

    public function sections()
    {
        return $this->hasMany(MsFormSection::class, 'formID', 'formID')
                    ->orderBy('sortOrder');
    }

    public function settings()
    {
        return $this->hasMany(MsFormSetting::class, 'formID', 'formID');
    }

    public function submissions()
    {
        return $this->hasMany(TrFormSubmission::class, 'formID', 'formID');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('flagActive', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOpenForSubmission($query)
    {
        $now = Carbon::now();

        return $query
            ->where('status', 'published')
            ->where('flagActive', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('startDate')->orWhere('startDate', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('endDate')->orWhere('endDate', '>=', $now);
            });
    }

    // -------------------------------------------------------------------------
    // Business Logic — called by Controller (thin controller pattern)
    // -------------------------------------------------------------------------

    /**
     * Generate a unique slug from a title.
     */
    public static function generateSlug(string $title): string
    {
        $slug     = Str::slug($title);
        $original = $slug;
        $i        = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $i++;
        }

        return $slug;
    }

    /**
     * Check whether this form is currently accepting submissions.
     */
    public function isAcceptingSubmissions(): bool
    {
        if (!$this->flagActive || $this->status !== 'published') {
            return false;
        }

        $now = Carbon::now();

        if ($this->startDate && $now->lt($this->startDate)) {
            return false;
        }

        if ($this->endDate && $now->gt($this->endDate)) {
            return false;
        }

        if ($this->maxSubmission && $this->totalSubmission >= $this->maxSubmission) {
            return false;
        }

        return true;
    }

    /**
     * Increment the denormalized submission counter atomically.
     */
    public function incrementSubmissionCount(): void
    {
        $this->increment('totalSubmission');
    }

    /**
     * Close all forms whose endDate has passed and are still published.
     * Called by the forms:close-expired console command.
     */
    public static function closeExpiredForms(): int
    {
        return self::where('status', 'published')
                   ->where('flagActive', true)
                   ->whereNotNull('endDate')
                   ->where('endDate', '<', Carbon::now())
                   ->update([
                       'status'    => 'closed',
                       'editedBy'  => 'system',
                       'editedDate' => Carbon::now(),
                   ]);
    }

    /**
     * Get a setting value by key (reads from ms_form_setting).
     */
    public function getSetting(string $key, $default = null)
    {
        $setting = $this->settings()->where('settingKey', $key)->first();

        if (!$setting) {
            return $default;
        }

        return match ($setting->settingType) {
            'integer' => (int) $setting->settingValue,
            'boolean' => (bool) $setting->settingValue,
            'json'    => json_decode($setting->settingValue, true),
            default   => $setting->settingValue,
        };
    }

    // -------------------------------------------------------------------------
    // Admin Index — getTableConfig() and searchAdminForms()
    // -------------------------------------------------------------------------

    public static function getTableConfig(): array
    {
        return [
            'idKey'        => 'formID',
            'emptyMessage' => 'No forms created yet.',
            'emptyIcon'    => 'fa-wpforms',
            'colspan'      => 7,
            'columns'      => [
                ['key' => 'title',           'type' => 'text',  'label' => 'Form Title'],
                ['key' => 'status',          'type' => 'badge', 'label' => 'Status',
                 'badgeMap' => [
                     'draft'     => 'secondary',
                     'published' => 'success',
                     'closed'    => 'warning',
                     'archived'  => 'dark',
                 ]],
                ['key' => 'totalSubmission', 'type' => 'text',  'label' => 'Submissions'],
                ['key' => 'createdBy',       'type' => 'text',  'label' => 'Created By'],
                ['key' => 'createdDate',     'type' => 'date',  'label' => 'Created Date',
                 'dateFormat' => 'DD MMM YYYY'],
            ],
            'actions' => [
                'view'   => ['enabled' => true, 'route' => 'admin.forms.show', 'routeKey' => 'formID'],
                'edit'   => ['enabled' => true, 'type' => 'link', 'route' => 'admin.forms.edit', 'routeKey' => 'formID'],
                'delete' => ['enabled' => true, 'class' => 'btn-danger', 'btnClass' => 'delete-btn'],
                'custom' => [
                    [
                        'enabled'  => true,
                        'route'    => 'admin.forms.builder',
                        'routeKey' => 'formID',
                        'icon'     => 'fa-hammer',
                        'class'    => 'btn-info',
                        'title'    => 'Form Builder',
                    ],
                ],
            ],
        ];
    }

    public static function searchAdminForms(Request $request)
    {
        $query = self::where('flagActive', true);

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('created_at')) {
            $parts     = explode(' - ', $request->created_at);
            $startDate = Carbon::createFromFormat('d-m-Y', trim($parts[0]))->startOfDay();
            $endDate   = Carbon::createFromFormat('d-m-Y', trim($parts[1] ?? $parts[0]))->endOfDay();
            $query->whereBetween('createdDate', [$startDate, $endDate]);
        }

        $sortBy = $request->input('sort_by', 'createdDate');
        if (!in_array($sortBy, static::$allowedSorts)) {
            $sortBy = 'createdDate';
        }

        $query->orderBy($sortBy, $request->input('sort_order', 'desc'));

        return $query->paginate(15)->appends($request->query());
    }
}
