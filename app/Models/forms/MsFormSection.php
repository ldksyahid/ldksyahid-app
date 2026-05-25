<?php

namespace App\Models\forms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MsFormSection extends Model
{
    protected $table      = 'ms_form_section';
    protected $primaryKey = 'formSectionID';
    public    $timestamps = false;

    protected $fillable = [
        'formID',
        'title',
        'description',
        'sortOrder',
        'flagActive',
        'createdDate',
        'editedDate',
    ];

    protected $casts = [
        'flagActive'  => 'boolean',
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

    public function fields()
    {
        return $this->hasMany(MsFormField::class, 'formSectionID', 'formSectionID')
                    ->where('flagActive', true)
                    ->orderBy('sortOrder');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('flagActive', true);
    }
}
