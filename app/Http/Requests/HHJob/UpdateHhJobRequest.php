<?php

declare(strict_types=1);

namespace App\Http\Requests\HHJob;

class UpdateHhJobRequest extends StoreHhJobRequest
{
    public function authorize(): bool
    {
        return true; // bisa dihubungkan ke Policy nanti
    }

    public function rules(): array
    {
        return [
            'company_id'      => 'required|exists:hh_companies,id',
            'category_id'     => 'required|exists:hh_job_categories,id',
            'job_title'       => 'required|string|max:255',
            'description'     => 'required|string',
            'job_type'        => 'required|string',
            'experience_level' => 'nullable|string',
            'city'            => 'nullable|string',
            'country'         => 'nullable|string',
            'salary_currency' => 'nullable|string|max:3',
            'min_salary'      => 'nullable|numeric',
            'max_salary'      => 'nullable|numeric',
            'is_featured'     => 'boolean',
            'is_open'         => 'boolean',
            'expires_at'      => 'nullable|date',
            'published_at'    => 'nullable|date',
        ];
    }
}
