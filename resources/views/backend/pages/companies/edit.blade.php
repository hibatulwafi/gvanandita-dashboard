{{-- resources/views/backend/pages/companies/edit.blade.php --}}
@extends('backend.layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Company: {{ $company->company_name }}</h1>

    <form action="{{ route('admin.headhunters.companies.update', $company->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block mb-1 font-medium">Company Name</label>
            <input type="text" name="company_name" value="{{ $company->company_name }}"
                class="w-full border rounded-lg p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Industry</label>
            <input type="text" name="industry" value="{{ $company->industry }}"
                class="w-full border rounded-lg p-2">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-medium">Contact Person Name</label>
                <input type="text" name="contact_person_name" value="{{ $company->contact_person_name }}"
                    class="w-full border rounded-lg p-2">
            </div>
            <div>
                <label class="block mb-1 font-medium">Contact Person Email</label>
                <input type="email" name="contact_person_email" value="{{ $company->contact_person_email }}"
                    class="w-full border rounded-lg p-2">
            </div>
        </div>

        <div>
            <label class="block mb-1 font-medium">Contact Person Phone</label>
            <input type="text" name="contact_person_phone" value="{{ $company->contact_person_phone }}"
                class="w-full border rounded-lg p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Address</label>
            <textarea name="address" rows="3" class="w-full border rounded-lg p-2">{{ $company->address }}</textarea>
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" name="is_active" value="1" id="is_active" class="rounded"
                {{ $company->is_active ? 'checked' : '' }}>
            <label for="is_active">Active</label>
        </div>

        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Update
        </button>
    </form>
</div>
@endsection