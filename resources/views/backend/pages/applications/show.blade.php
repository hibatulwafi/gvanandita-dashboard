@extends('backend.layouts.app')

@section('title')
{{ __($breadcrumbs['title']) }} | {{ config('app.name') }}
@endsection

@section('admin-content')

<div class="p-6 max-w-4xl mx-auto">
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Application Details</h1>

    <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-900">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
            {{-- Bagian Kiri --}}
            <div>
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-300">Application Information</h3>
                    <hr class="mt-1 mb-2 border-gray-200 dark:border-gray-700">
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Candidate:</span>
                            <span class="text-gray-900 dark:text-white">{{ $application->candidate->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Job Title:</span>
                            <span class="text-gray-900 dark:text-white">{{ $application->jobListing->job_title ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Applied At:</span>
                            <span class="text-gray-900 dark:text-white">{{ $application->applied_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">Status:</span>
                            <span class="text-gray-900 dark:text-white">{{ $application->status }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan --}}
            <div>
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-300">Feedback</h3>
                    <hr class="mt-1 mb-2 border-gray-200 dark:border-gray-700">
                    <div class="prose dark:prose-invert">
                        <p class="text-gray-900 dark:text-white">{{ $application->feedback ?? 'No feedback provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-6 flex justify-end space-x-2">
            <a href="#"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Edit
            </a>
            <form action="{{ route('admin.headhunters.applications.destroy', $application->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this application?');">
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