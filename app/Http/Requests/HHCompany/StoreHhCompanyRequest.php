<?php

namespace App\Http\Requests\HHCompany;

use Illuminate\Foundation\Http\FormRequest;

class StoreHhCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        // bisa diganti logic authorization sesuai kebutuhan
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'              => ['required', 'exists:users,id'],
            'company_name'         => ['required', 'string', 'max:255'],
            'contact_person_name'  => ['required', 'string', 'max:255'],
            'contact_person_email' => ['required', 'email', 'max:255'],
            'contact_person_phone' => ['nullable', 'string', 'max:50'],
            'address'              => ['nullable', 'string'],
            'industry'             => ['nullable', 'string', 'max:255'],
            'is_active'            => ['boolean'],
        ];
    }
}
