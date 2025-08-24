<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HhCompany extends Model
{
    use HasFactory;

    protected $table = 'hh_companies';

    protected $fillable = [
        'user_id',
        'company_name',
        'contact_person_name',
        'contact_person_email',
        'contact_person_phone',
        'address',
        'industry',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
