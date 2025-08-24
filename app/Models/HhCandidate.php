<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HhCandidate extends Model
{
    use HasFactory;

    // Nama tabel (karena tidak ikut konvensi jamak Laravel)
    protected $table = 'hh_candidates';

    // Kolom yang bisa diisi mass assignment
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
        'address',
        'current_job_title',
        'current_company',
        'employment_status',
        'willing_to_relocate',
        'work_experience_years',
        'skills',
        'resume_path',
        'portfolio_url',
        'linkedin_url',
        'current_salary',
        'expected_salary',
        'email_verification_token',
        'email_verified_at',
        'phone_verification_token',
        'phone_verified_at',
        'is_active',
        'is_profile_complete',
    ];

    // Tipe data casting
    protected $casts = [
        'email_verified_at'   => 'datetime',
        'phone_verified_at'   => 'datetime',
        'is_active'           => 'boolean',
        'is_profile_complete' => 'boolean',
        'current_salary'      => 'decimal:2',
        'expected_salary'     => 'decimal:2',
    ];
}
