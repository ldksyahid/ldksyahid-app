<?php

namespace App\Models\forms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TrFormSubmission extends Model
{
    protected $table      = 'tr_form_submission';
    protected $primaryKey = 'formSubmissionID';
    public    $timestamps = false;

    protected $fillable = [
        'formID',
        'respondentEmail',
        'respondentName',
        'respondentPhone',
        'gsheetRowIndex',
        'ipAddress',
        'userAgent',
        'flagValid',
        'formVersion',
        'submittedAt',
    ];

    protected $casts = [
        'flagValid'   => 'boolean',
        'submittedAt' => 'datetime',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function form()
    {
        return $this->belongsTo(MsForm::class, 'formID', 'formID');
    }

    public function files()
    {
        return $this->hasMany(TrFormFile::class, 'formSubmissionID', 'formSubmissionID');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scopeValid($query)
    {
        return $query->where('flagValid', true);
    }

    public function scopeForForm($query, int $formID)
    {
        return $query->where('formID', $formID);
    }

    // -------------------------------------------------------------------------
    // Business Logic
    // -------------------------------------------------------------------------

    /**
     * Record a new submission with minimal metadata.
     * Actual answers are stored in Google Sheets (see DynamicFormGDriveService).
     */
    public static function record(
        int     $formID,
        string  $email,
        ?string $name,
        ?string $phone,
        ?int    $gsheetRowIndex,
        string  $ipAddress,
        string  $userAgent,
        int     $formVersion
    ): self {
        return self::create([
            'formID'          => $formID,
            'respondentEmail' => $email,
            'respondentName'  => $name,
            'respondentPhone' => $phone,
            'gsheetRowIndex'  => $gsheetRowIndex,
            'ipAddress'       => $ipAddress,
            'userAgent'       => $userAgent,
            'flagValid'       => true,
            'formVersion'     => $formVersion,
            'submittedAt'     => Carbon::now(),
        ]);
    }

    /**
     * Check whether a given email has ever submitted this form.
     * Used to enforce single-submission restriction (isMultipleSubmit = false).
     * Returns false if email is empty (no email field on the form).
     */
    public static function hasSubmittedBefore(int $formID, string $email): bool
    {
        if (empty($email)) return false;

        return self::where('formID', $formID)
                   ->where('respondentEmail', $email)
                   ->exists();
    }

    /**
     * Check whether an IP has exceeded the rate limit for a given form.
     * Falls back to a 5/10-minute limit if form settings are not found.
     */
    public static function isRateLimited(int $formID, string $ipAddress): bool
    {
        $form = MsForm::find($formID);

        $maxPerIp      = (int) ($form?->getSetting(MsFormSetting::KEY_RATE_LIMIT_PER_IP, 5));
        $windowMinutes = (int) ($form?->getSetting(MsFormSetting::KEY_RATE_LIMIT_WINDOW_MIN, 10));

        $since = Carbon::now()->subMinutes($windowMinutes);

        $count = self::where('formID', $formID)
                     ->where('ipAddress', $ipAddress)
                     ->where('submittedAt', '>=', $since)
                     ->count();

        return $count >= $maxPerIp;
    }

    /**
     * When isRateLimited() is true, this tells you how many seconds until
     * it clears — i.e. how long until the oldest submission inside the
     * current rolling window ages out and drops the count back under the
     * limit. Returns null if the IP isn't currently rate-limited.
     */
    public static function rateLimitRetryAfterSeconds(int $formID, string $ipAddress): ?int
    {
        $form = MsForm::find($formID);

        $maxPerIp      = (int) ($form?->getSetting(MsFormSetting::KEY_RATE_LIMIT_PER_IP, 5));
        $windowMinutes = (int) ($form?->getSetting(MsFormSetting::KEY_RATE_LIMIT_WINDOW_MIN, 10));

        $since = Carbon::now()->subMinutes($windowMinutes);

        $recent = self::where('formID', $formID)
                     ->where('ipAddress', $ipAddress)
                     ->where('submittedAt', '>=', $since)
                     ->orderBy('submittedAt', 'asc')
                     ->get(['submittedAt']);

        if ($recent->count() < $maxPerIp) {
            return null;
        }

        // The count only drops back under the limit once enough of the
        // oldest submissions age out — the (count - maxPerIp + 1)-th oldest
        // one is the one whose expiry actually unblocks the next attempt.
        $blockingSubmission = $recent[$recent->count() - $maxPerIp];
        $availableAt        = $blockingSubmission->submittedAt->copy()->addMinutes($windowMinutes);

        return max(0, (int) Carbon::now()->diffInSeconds($availableAt, false));
    }

    /**
     * After a sheet row is physically deleted (DynamicFormGDriveService::deleteRow()),
     * every row below it shifts up by one — keep every other submission's
     * cached row pointer in sync. This is a best-effort cache: any write
     * path (edit/delete) MUST still re-resolve the true row via
     * DynamicFormGDriveService::findRowIndexBySubmissionId() before trusting
     * it, so a missed/partial decrement here self-heals on the next write.
     */
    public static function decrementRowIndexesAfter(int $formID, int $deletedRowIndex): void
    {
        self::where('formID', $formID)
            ->where('gsheetRowIndex', '>', $deletedRowIndex)
            ->decrement('gsheetRowIndex');
    }
}
