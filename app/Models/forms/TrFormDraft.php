<?php

namespace App\Models\forms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TrFormDraft extends Model
{
    protected $table      = 'tr_form_draft';
    protected $primaryKey = 'formDraftID';
    public    $timestamps = false;

    protected $fillable = [
        'formID',
        'userID',
        'answers',
        'createdDate',
        'editedDate',
    ];

    protected $casts = [
        'answers'     => 'array',
        'createdDate' => 'datetime',
        'editedDate'  => 'datetime',
    ];

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
     * Fetch the saved answers for a user's in-progress draft of a form, if any.
     */
    public static function findAnswers(int $formID, int $userID): ?array
    {
        $draft = self::where('formID', $formID)->where('userID', $userID)->first();

        return $draft?->answers;
    }

    /**
     * Create or update the single draft row for this (form, user) pair.
     */
    public static function upsertAnswers(int $formID, int $userID, array $answers): void
    {
        $draft = self::where('formID', $formID)->where('userID', $userID)->first();
        $now   = Carbon::now();

        if ($draft) {
            $draft->answers    = $answers;
            $draft->editedDate = $now;
            $draft->save();
            return;
        }

        self::create([
            'formID'      => $formID,
            'userID'      => $userID,
            'answers'     => $answers,
            'createdDate' => $now,
            'editedDate'  => $now,
        ]);
    }

    /**
     * Discard the draft — called once a real submission succeeds.
     */
    public static function clear(int $formID, int $userID): void
    {
        self::where('formID', $formID)->where('userID', $userID)->delete();
    }
}
