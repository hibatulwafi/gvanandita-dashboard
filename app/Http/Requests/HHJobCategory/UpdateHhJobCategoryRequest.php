<?php

namespace App\Http\Requests\HHJobCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHhJobCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('category');

        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:hh_job_categories,slug,' . $id,
        ];
    }
}
