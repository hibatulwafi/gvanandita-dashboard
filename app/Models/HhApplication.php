<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HhApplication extends Model
{
    use HasFactory;

    protected $table = 'hh_applications';

    protected $fillable = [
        'candidate_id',
        'job_listing_id',
        'status',
        'applied_at',
        'feedback',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
    ];

    public function candidate()
    {
        return $this->belongsTo(HhCandidate::class, 'candidate_id');
    }

    public function jobListing()
    {
        return $this->belongsTo(HhJobListing::class, 'job_listing_id');
    }
}
