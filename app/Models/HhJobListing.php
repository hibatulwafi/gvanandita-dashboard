<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HhJobListing extends Model
{
    use HasFactory;

    protected $table = 'hh_job_listings';

    protected $fillable = [
        'company_id',
        'category_id',
        'job_title',
        'description',
        'job_location_type',
        'experience_level',
        'city',
        'country',
        'salary_currency',
        'min_salary',
        'max_salary',
        'job_type',
        'is_featured',
        'is_open',
        'expires_at',
        'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_open'     => 'boolean',
        'expires_at'  => 'datetime',
        'published_at'=> 'datetime',
        'min_salary'  => 'decimal:2',
        'max_salary'  => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(HhCompany::class, 'company_id');
    }

    public function category()
    {
        return $this->belongsTo(HhJobCategory::class, 'category_id');
    }
}
