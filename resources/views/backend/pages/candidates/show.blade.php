@extends('backend.layouts.app')

@section('title')
{{ $breadcrumbs['title'] }} | {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <div class="space-y-6">
        <div class="rounded-md border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <!-- Header -->
            <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-base font-medium text-gray-700 dark:text-white/90 flex items-center gap-2">
                    <iconify-icon icon="lucide:user" class="w-5 h-5 text-primary-500"></iconify-icon>
                    {{ __('Candidate Details') }}
                </h3>
                <div class="flex gap-2">
                    @can('candidate.edit')
                    <a href="{{ route('admin.candidates.edit', $candidate->id) }}" class="btn-primary flex items-center">
                        <iconify-icon icon="lucide:pencil" class="mr-2"></iconify-icon>
                        {{ __('Edit') }}
                    </a>
                    @endcan
                    <a href="{{ route('admin.headhunters.candidates.index') }}" class="btn-default flex items-center">
                        <iconify-icon icon="lucide:arrow-left" class="mr-2"></iconify-icon>
                        {{ __('Back') }}
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="px-5 py-4 sm:px-6 sm:py-5 space-y-8">
                <!-- Informasi Pribadi -->
                <div>
                    <h4 class="text-lg font-medium text-gray-700 dark:text-white/90 mb-3 flex items-center gap-2">
                        <iconify-icon icon="lucide:id-card" class="w-5 h-5 text-primary-500"></iconify-icon>
                        {{ __('Personal Information') }}
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="flex"><span class="w-40 font-medium text-gray-600">First Name:</span><span>{{ $candidate->first_name }}</span></div>
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Last Name:</span><span>{{ $candidate->last_name }}</span></div>
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Email:</span><span>{{ $candidate->email }}</span></div>
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Phone:</span><span>{{ $candidate->phone_number }}</span></div>
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Address:</span><span>{{ $candidate->address }}</span></div>
                    </div>
                </div>

                <hr />

                <!-- Karir -->
                <div>
                    <h4 class="text-lg font-medium text-gray-700 dark:text-white/90 mb-3 flex items-center gap-2">
                        <iconify-icon icon="lucide:briefcase" class="w-5 h-5 text-primary-500"></iconify-icon>
                        {{ __('Career Information') }}
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Job Title:</span><span>{{ $candidate->current_job_title }}</span></div>
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Company:</span><span>{{ $candidate->current_company }}</span></div>
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Status:</span><span>{{ $candidate->employment_status }}</span></div>
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Relocate:</span><span>{{ $candidate->willing_to_relocate ? 'Yes' : 'No' }}</span></div>
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Experience:</span><span>{{ $candidate->work_experience_years }} years</span></div>
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Skills:</span><span>{{ $candidate->skills }}</span></div>
                    </div>
                </div>

                <hr />

                <!-- Finansial -->
                <div>
                    <h4 class="text-lg font-medium text-gray-700 dark:text-white/90 mb-3 flex items-center gap-2">
                        <iconify-icon icon="lucide:banknote" class="w-5 h-5 text-green-500"></iconify-icon>
                        {{ __('Financial Information') }}
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Current Salary:</span><span>Rp {{ number_format($candidate->current_salary) }}</span></div>
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Expected Salary:</span><span>Rp {{ number_format($candidate->expected_salary) }}</span></div>
                    </div>
                </div>

                <hr />

                <!-- Dokumen & Link -->
                <div>
                    <h4 class="text-lg font-medium text-gray-700 dark:text-white/90 mb-3 flex items-center gap-2">
                        <iconify-icon icon="lucide:link" class="w-5 h-5 text-blue-500"></iconify-icon>
                        {{ __('Documents & Links') }}
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="flex">
                            <span class="w-40 font-medium text-gray-600">Resume:</span>
                            <span>
                                @if($candidate->resume_path)
                                    <a href="{{ asset('storage/'.$candidate->resume_path) }}" target="_blank" class="text-blue-500 underline">View</a>
                                @else
                                    <span class="text-gray-500">Not uploaded</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex">
                            <span class="w-40 font-medium text-gray-600">Portfolio:</span>
                            <span>
                                @if($candidate->portfolio_url)
                                    <a href="{{ $candidate->portfolio_url }}" target="_blank" class="text-blue-500 underline">Open</a>
                                @else
                                    <span class="text-gray-500">N/A</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex">
                            <span class="w-40 font-medium text-gray-600">LinkedIn:</span>
                            <span>
                                @if($candidate->linkedin_url)
                                    <a href="{{ $candidate->linkedin_url }}" target="_blank" class="text-blue-500 underline">Profile</a>
                                @else
                                    <span class="text-gray-500">N/A</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <hr />

                <!-- Verifikasi -->
                <div>
                    <h4 class="text-lg font-medium text-gray-700 dark:text-white/90 mb-3 flex items-center gap-2">
                        <iconify-icon icon="lucide:shield-check" class="w-5 h-5 text-emerald-500"></iconify-icon>
                        {{ __('Verification') }}
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Email Verified:</span><span>{{ $candidate->email_verified_at ? $candidate->email_verified_at->format('M d, Y H:i') : 'No' }}</span></div>
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Phone Verified:</span><span>{{ $candidate->phone_verified_at ? $candidate->phone_verified_at->format('M d, Y H:i') : 'No' }}</span></div>
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Active:</span><span>{{ $candidate->is_active ? 'Yes' : 'No' }}</span></div>
                        <div class="flex"><span class="w-40 font-medium text-gray-600">Profile Complete:</span><span>{{ $candidate->is_profile_complete ? 'Yes' : 'No' }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
