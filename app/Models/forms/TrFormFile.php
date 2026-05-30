<?php

namespace App\Models\forms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TrFormFile extends Model
{
    protected $table      = 'tr_form_file';
    protected $primaryKey = 'formFileID';
    public    $timestamps = false;

    protected $fillable = [
        'formSubmissionID',
        'formFieldID',
        'originalFileName',
        'mimeType',
        'fileSizeKB',
        'gdriveFileID',
        'gdriveFolderID',
        'gdriveFileUrl',
        'createdDate',
    ];

    protected $casts = [
        'createdDate' => 'datetime',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function submission()
    {
        return $this->belongsTo(TrFormSubmission::class, 'formSubmissionID', 'formSubmissionID');
    }

    public function field()
    {
        return $this->belongsTo(MsFormField::class, 'formFieldID', 'formFieldID');
    }

    // -------------------------------------------------------------------------
    // Business Logic
    // -------------------------------------------------------------------------

    /**
     * Record a GDrive file upload for a submission.
     */
    public static function record(
        int    $submissionID,
        int    $fieldID,
        string $originalFileName,
        string $mimeType,
        int    $fileSizeKB,
        string $gdriveFileID,
        string $gdriveFolderID,
        string $gdriveFileUrl
    ): self {
        return self::create([
            'formSubmissionID' => $submissionID,
            'formFieldID'      => $fieldID,
            'originalFileName' => $originalFileName,
            'mimeType'         => $mimeType,
            'fileSizeKB'       => $fileSizeKB,
            'gdriveFileID'     => $gdriveFileID,
            'gdriveFolderID'   => $gdriveFolderID,
            'gdriveFileUrl'    => $gdriveFileUrl,
            'createdDate'      => Carbon::now(),
        ]);
    }
}
