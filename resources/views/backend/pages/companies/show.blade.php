@extends('backend.layouts.app')

@section('title')
{{ __($breadcrumbs['title']) }} | {{ config('app.name') }}
@endsection

@section('admin-content')

<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-900">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
            {{-- Bagian Kiri --}}
            <div>
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-300">Basic Information</h3>
                    <hr class="mt-1 mb-2 border-gray-200 dark:border-gray-700">
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Industry:</span>
                            <span class="text-gray-900 dark:text-white">{{ $company->industry }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Status:</span>
                            <span class="text-gray-900 dark:text-white">{{ $company->is_active ? 'Active' : 'Inactive' }}</span>
                        </div>
                        @if ($company->address)
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Address:</span>
                            <span class="text-gray-900 dark:text-white">{{ $company->address }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan --}}
            <div>
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-300">Contact Person</h3>
                    <hr class="mt-1 mb-2 border-gray-200 dark:border-gray-700">
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Name:</span>
                            <span class="text-gray-900 dark:text-white">{{ $company->contact_person_name }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Email:</span>
                            <span class="text-gray-900 dark:text-white">{{ $company->contact_person_email }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Phone:</span>
                            <span class="text-gray-900 dark:text-white">{{ $company->contact_person_phone }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection