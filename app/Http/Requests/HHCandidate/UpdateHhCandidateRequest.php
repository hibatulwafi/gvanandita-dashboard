<?php

declare(strict_types=1);

namespace App\Http\Requests\HHCandidate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHhCandidateRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Sesuaikan dengan logic otorisasi Anda jika diperlukan.
        // Contoh: return $this->user()->can('update', $this->route('id'));
        return true;
    }

    public function rules(): array
    {
        $candidateId = $this->route('id');

        return [
            'first_name'            => ['required', 'string', 'max:255'],
            'last_name'             => ['nullable', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', Rule::unique('hh_candidates')->ignore($candidateId)],
            'phone_number'          => ['nullable', 'string', 'max:255'],
            'password'              => ['nullable', 'string', 'min:8'],
            'address'               => ['nullable', 'string', 'max:255'],
            'current_job_title'     => ['nullable', 'string', 'max:255'],
            'current_company'       => ['nullable', 'string', 'max:255'],
            'employment_status'     => ['nullable', 'string', 'max:255'],
            'willing_to_relocate'   => ['nullable', 'boolean'],
            'work_experience_years' => ['nullable', 'integer', 'min:0'],
            'skills'                => ['nullable', 'string'],
            'resume_file'           => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
            'remove_resume'         => ['nullable', 'boolean'],
            'portfolio_url'         => ['nullable', 'url', 'max:255'],
            'linkedin_url'          => ['nullable', 'url', 'max:255'],
            'current_salary'        => ['nullable', 'numeric'],
            'expected_salary'       => ['nullable', 'numeric'],
            'is_active'             => ['nullable', 'boolean'],
            'is_profile_complete'   => ['nullable', 'boolean'],
        ];
    }
}
