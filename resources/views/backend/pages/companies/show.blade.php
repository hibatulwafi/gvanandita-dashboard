{{-- resources/views/backend/pages/companies/show.blade.php --}}
@extends('backend.layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Company: {{ $company->company_name }}</h1>

    <div class="bg-white shadow rounded-lg p-6 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="flex">
                <span class="w-40 font-medium text-gray-600">Industry</span>
                <span>{{ $company->industry }}</span>
            </div>
            <div class="flex">
                <span class="w-40 font-medium text-gray-600">Active</span>
                <span>{{ $company->is_active ? 'Yes' : 'No' }}</span>
            </div>
            <div class="flex">
                <span class="w-40 font-medium text-gray-600">Contact Person</span>
                <span>{{ $company->contact_person_name }}</span>
            </div>
            <div class="flex">
                <span class="w-40 font-medium text-gray-600">Email</span>
                <span>{{ $company->contact_person_email }}</span>
            </div>
            <div class="flex">
                <span class="w-40 font-medium text-gray-600">Phone</span>
                <span>{{ $company->contact_person_phone }}</span>
            </div>
            <div class="flex">
                <span class="w-40 font-medium text-gray-600">Address</span>
                <span>{{ $company->address }}</span>
            </div>
        </div>
    </div>
</div>
@endsection