<?php

namespace App\Http\Requests\HHJobCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreHhJobCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // bisa dihubungkan ke policy kalau ada
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:hh_job_categories,slug',
        ];
    }
}
