@extends('backend.layouts.app')

@section('title')
{{ __($breadcrumbs['title']) }} | {{ config('app.name') }}
@endsection

@section('admin-content')

<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">{{ __('Application Details') }}</h1>

    <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-900">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-12 gap-y-6">
            {{-- Left Side: Application Information --}}
            <div>
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Application Information') }}</h3>
                    <hr class="mt-1 mb-2 border-gray-200 dark:border-gray-700">
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Job Title') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ optional($application->jobListing)->job_title ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Status') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ $application->status }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Applied At') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ optional($application->applied_at)->format('d M Y') ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Full Candidate Information --}}
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Candidate Information') }}</h3>
                    <hr class="mt-1 mb-2 border-gray-200 dark:border-gray-700">
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Name') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ optional($application->candidate)->first_name . ' ' . optional($application->candidate)->last_name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Email') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ optional($application->candidate)->email ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Phone') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ optional($application->candidate)->phone_number ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Experience') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ optional($application->candidate)->work_experience_years ?? 'N/A' }} years</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Current Salary') }}:</span>
                            <span class="text-gray-900 dark:text-white">
                                @if(optional($application->candidate)->current_salary)
                                Rp {{ number_format($application->candidate->current_salary) }}
                                @else
                                N/A
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Expected Salary') }}:</span>
                            <span class="text-gray-900 dark:text-white">
                                @if(optional($application->candidate)->expected_salary)
                                Rp {{ number_format($application->candidate->expected_salary) }}
                                @else
                                N/A
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Willing to Relocate') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ optional($application->candidate)->willing_to_relocate ? 'Yes' : 'No' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Profile Status') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ optional($application->candidate)->is_profile_complete ? 'Complete' : 'Incomplete' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Resume') }}:</span>
                            <span>
                                @if(optional($application->candidate)->resume_path)
                                <a href="{{ asset('storage/' . $application->candidate->resume_path) }}" target="_blank" class="text-blue-500 underline">{{ __('View Resume') }}</a>
                                @else
                                <span class="text-gray-500">{{ __('Not uploaded') }}</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side --}}
            <div>
                {{-- Full Job Information --}}
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Job Details') }}</h3>
                    <hr class="mt-1 mb-2 border-gray-200 dark:border-gray-700">
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Company') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ optional($application->jobListing->company)->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Location Type') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ optional($application->jobListing)->job_location_type ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Experience Level') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ optional($application->jobListing)->experience_level ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Job Type') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ optional($application->jobListing)->job_type ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Salary') }}:</span>
                            <span class="text-gray-900 dark:text-white">
                                {{ optional($application->jobListing)->salary_currency ?? 'N/A' }} {{ number_format(optional($application->jobListing)->min_salary) }} - {{ number_format(optional($application->jobListing)->max_salary) }}
                            </span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 w-32 dark:text-gray-400">{{ __('Description') }}:</span>
                        </div>
                        <p class="mt-2 text-gray-900 dark:text-white prose dark:prose-invert">
                            {{ optional($application->jobListing)->description ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>

            <div>
                {{-- Form to Update Status & Feedback --}}
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Update Status & Feedback') }}</h3>
                    <hr class="mt-1 mb-2 border-gray-200 dark:border-gray-700">
                    <form action="{{ route('admin.headhunters.applications.update', $application->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="flex flex-col">
                            <label for="status" class="font-medium text-gray-600 dark:text-gray-400 mb-1">{{ __('New Status') }}</label>
                            <select name="status" id="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                                <option value="applied" {{ $application->status == 'applied' ? 'selected' : '' }}>{{ __('Applied') }}</option>
                                <option value="in_review" {{ $application->status == 'in_review' ? 'selected' : '' }}>{{ __('In Review') }}</option>
                                <option value="interview" {{ $application->status == 'interview' ? 'selected' : '' }}>{{ __('Interview') }}</option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                                <option value="hired" {{ $application->status == 'hired' ? 'selected' : '' }}>{{ __('Hired') }}</option>
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label for="feedback" class="font-medium text-gray-600 dark:text-gray-400 mb-1 mt-4">{{ __('Feedback') }}</label>
                            <textarea name="feedback" id="feedback" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700 dark:text-white">{{ $application->feedback ?? '' }}</textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            {{ __('Save Changes') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection