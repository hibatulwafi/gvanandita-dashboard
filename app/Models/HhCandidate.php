<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class HhCandidate extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'hh_candidates';

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

    protected $casts = [
        'email_verified_at'   => 'datetime',
        'phone_verified_at'   => 'datetime',
        'is_active'           => 'boolean',
        'is_profile_complete' => 'boolean',
        'current_salary'      => 'decimal:2',
        'expected_salary'     => 'decimal:2',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
