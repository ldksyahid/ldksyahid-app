<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Donation extends Model
{
    use HasFactory, UsesUuid;
    protected $guarded =[];

    public function campaign() {
        return $this->belongTo('App\Models\Campaign', 'campaign_id');
    }
}
