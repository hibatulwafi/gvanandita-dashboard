@extends('backend.layouts.app')

@section('title')
{{ __($breadcrumbs['title']) }} | {{ config('app.name') }}
@endsection

@section('admin-content')

<div class="p-6 max-w-4xl mx-auto">
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Job: {{ $job->job_title }}</h1>

    <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-900">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
            {{-- Bagian Kiri --}}
            <div>
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-300">Basic Information</h3>
                    <hr class="mt-1 mb-2 border-gray-200 dark:border-gray-700">
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Company:</span>
                            <span class="text-gray-900 dark:text-white">{{ $job->company->company_name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Category:</span>
                            <span class="text-gray-900 dark:text-white">{{ $job->category->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Location Type:</span>
                            <span class="text-gray-900 dark:text-white">{{ $job->job_location_type }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Experience Level:</span>
                            <span class="text-gray-900 dark:text-white">{{ $job->experience_level }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Job Type:</span>
                            <span class="text-gray-900 dark:text-white">{{ $job->job_type }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Status:</span>
                            <span class="text-gray-900 dark:text-white">{{ $job->is_open ? 'Open' : 'Closed' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Featured:</span>
                            <span class="text-gray-900 dark:text-white">{{ $job->is_featured ? 'Yes' : 'No' }}</span>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-300">Location</h3>
                    <hr class="mt-1 mb-2 border-gray-200 dark:border-gray-700">
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">City:</span>
                            <span class="text-gray-900 dark:text-white">{{ $job->city }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Country:</span>
                            <span class="text-gray-900 dark:text-white">{{ $job->country }}</span>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-300">Dates</h3>
                    <hr class="mt-1 mb-2 border-gray-200 dark:border-gray-700">
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Published:</span>
                            <span class="text-gray-900 dark:text-white">{{ $job->published_at ? $job->published_at->format('d M Y') : 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Expires:</span>
                            <span class="text-gray-900 dark:text-white">{{ $job->expires_at ? $job->expires_at->format('d M Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan --}}
            <div>
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-300">Salary</h3>
                    <hr class="mt-1 mb-2 border-gray-200 dark:border-gray-700">
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Currency:</span>
                            <span class="text-gray-900 dark:text-white">{{ $job->salary_currency }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Range:</span>
                            <span class="text-gray-900 dark:text-white">
                                {{ number_format($job->min_salary) }} - {{ number_format($job->max_salary) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-300">Description</h3>
                    <hr class="mt-1 mb-2 border-gray-200 dark:border-gray-700">
                    <div class="prose dark:prose-invert">
                        <p class="text-gray-900 dark:text-white">{{ $job->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('admin.headhunters.jobs.edit', $job->id) }}"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Edit
            </a>
            <form action="{{ route('admin.headhunters.jobs.destroy', $job->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this job?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-red-600 border border-red-600 rounded-md hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete
                </button>
            </form>
        </div>
    </div>

</div>
@endsection