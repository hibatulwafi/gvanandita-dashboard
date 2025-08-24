<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HhJobCategory extends Model
{
    use HasFactory;

    protected $table = 'hh_job_categories';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function jobListings()
    {
        return $this->hasMany(HhJobListing::class, 'category_id');
    }
}
