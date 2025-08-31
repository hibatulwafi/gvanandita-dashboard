@extends('backend.layouts.app')

@section('title')
{{ __($breadcrumbs['title']) }} | {{ config('app.name') }}
@endsection


@section('admin-content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6"
    x-data="{ selectedCompanies: [], selectAll: false, bulkDeleteModalOpen: false }">

    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <div class="space-y-6">
        <div class="rounded-md border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5 flex flex-col md:flex-row justify-between items-center gap-3">
                {{-- Search --}}
                @include('backend.partials.search-form', [
                'placeholder' => __('Search by name or email'),
                ])

                <div class="flex items-center gap-3">
                    {{-- Bulk Actions --}}
                    <div class="relative flex items-center justify-center"
                        x-data="{ open: false }"
                        x-show="selectedadmin.headhunters.candidates.length > 0">
                        <button @click="open = !open"
                            class="btn-secondary flex items-center justify-center gap-2 text-sm" type="button">
                            <iconify-icon icon="lucide:more-vertical"></iconify-icon>
                            <span>{{ __('Bulk Actions') }} (<span x-text="selectedadmin.headhunters.candidates.length"></span>)</span>
                            <iconify-icon icon="lucide:chevron-down"></iconify-icon>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 top-10 w-48 rounded-md shadow bg-white dark:bg-gray-700 z-10 p-2">
                            <ul class="space-y-2">
                                <li class="cursor-pointer flex items-center gap-1 text-sm text-red-600 dark:text-red-500 hover:bg-red-50 dark:hover:bg-red-500 dark:hover:text-red-50 px-2 py-1.5 rounded transition-colors duration-300"
                                    @click="open = false; bulkDeleteModalOpen = true">
                                    <iconify-icon icon="lucide:trash"></iconify-icon> {{ __('Delete Selected') }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Status Active Filter --}}
                    <div class="relative flex items-center justify-center" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="btn-secondary flex items-center justify-center gap-2 text-sm" type="button">
                            <iconify-icon icon="lucide:filter"></iconify-icon>
                            <span class="hidden sm:inline">{{ __('Active') }}</span>
                            @if(request('is_active') !== null)
                            <span class="px-2 py-0.5 text-xs bg-indigo-100 text-indigo-800 rounded-full">
                                {{ request('is_active') ? 'Active' : 'Inactive' }}
                            </span>
                            @endif
                            <iconify-icon icon="lucide:chevron-down"></iconify-icon>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 top-10 w-40 rounded-md shadow bg-white dark:bg-gray-700 z-10 p-2">
                            <ul class="space-y-2">
                                <li class="cursor-pointer text-sm px-2 py-1.5 rounded hover:bg-gray-200 dark:hover:bg-gray-600 {{ request('is_active') === null ? 'bg-gray-200 dark:bg-gray-600' : '' }}"
                                    @click="window.location='{{ route('admin.headhunters.candidates.index', ['search' => request('search'), 'is_profile_complete' => request('is_profile_complete')]) }}'">
                                    {{ __('All') }}
                                </li>
                                <li class="cursor-pointer text-sm px-2 py-1.5 rounded hover:bg-gray-200 dark:hover:bg-gray-600 {{ request('is_active') == 1 ? 'bg-gray-200 dark:bg-gray-600' : '' }}"
                                    @click="window.location='{{ route('admin.headhunters.candidates.index', ['search' => request('search'), 'is_active' => 1, 'is_profile_complete' => request('is_profile_complete')]) }}'">
                                    {{ __('Active') }}
                                </li>
                                <li class="cursor-pointer text-sm px-2 py-1.5 rounded hover:bg-gray-200 dark:hover:bg-gray-600 {{ request('is_active') == 0 ? 'bg-gray-200 dark:bg-gray-600' : '' }}"
                                    @click="window.location='{{ route('admin.headhunters.candidates.index', ['search' => request('search'), 'is_active' => 0, 'is_profile_complete' => request('is_profile_complete')]) }}'">
                                    {{ __('Inactive') }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Profile Complete Filter --}}
                    <div class="relative flex items-center justify-center" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="btn-secondary flex items-center justify-center gap-2 text-sm" type="button">
                            <iconify-icon icon="lucide:user-check"></iconify-icon>
                            <span class="hidden sm:inline">{{ __('Profile') }}</span>
                            @if(request('is_profile_complete') !== null)
                            <span class="px-2 py-0.5 text-xs bg-blue-100 text-blue-800 rounded-full">
                                {{ request('is_profile_complete') ? 'Complete' : 'Incomplete' }}
                            </span>
                            @endif
                            <iconify-icon icon="lucide:chevron-down"></iconify-icon>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 top-10 w-40 rounded-md shadow bg-white dark:bg-gray-700 z-10 p-2">
                            <ul class="space-y-2">
                                <li class="cursor-pointer text-sm px-2 py-1.5 rounded hover:bg-gray-200 dark:hover:bg-gray-600 {{ request('is_profile_complete') === null ? 'bg-gray-200 dark:bg-gray-600' : '' }}"
                                    @click="window.location='{{ route('admin.headhunters.candidates.index', ['search' => request('search'), 'is_active' => request('is_active')]) }}'">
                                    {{ __('All') }}
                                </li>
                                <li class="cursor-pointer text-sm px-2 py-1.5 rounded hover:bg-gray-200 dark:hover:bg-gray-600 {{ request('is_profile_complete') == 1 ? 'bg-gray-200 dark:bg-gray-600' : '' }}"
                                    @click="window.location='{{ route('admin.headhunters.candidates.index', ['search' => request('search'), 'is_active' => request('is_active'), 'is_profile_complete' => 1]) }}'">
                                    {{ __('Complete') }}
                                </li>
                                <li class="cursor-pointer text-sm px-2 py-1.5 rounded hover:bg-gray-200 dark:hover:bg-gray-600 {{ request('is_profile_complete') == 0 ? 'bg-gray-200 dark:bg-gray-600' : '' }}"
                                    @click="window.location='{{ route('admin.headhunters.candidates.index', ['search' => request('search'), 'is_active' => request('is_active'), 'is_profile_complete' => 0]) }}'">
                                    {{ __('Incomplete') }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Tambah Candidate --}}
                    @can('candidate.create')
                    <a href="{{ route('admin.headhunters.candidates.create') }}" class="btn-primary flex items-center gap-2">
                        <iconify-icon icon="feather:plus" height="16"></iconify-icon>
                        {{ __('New Candidate') }}
                    </a>
                    @endcan
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table id="dataTable" class="table min-w-full">
                    <thead class="table-thead">
                        <tr class="table-tr">
                            <th width="3%" class="table-thead-th">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-primary"
                                    x-model="selectAll"
                                    @click="
                                    selectAll = !selectAll;
                                    selectedCandidates = selectAll ? 
                                        [...document.querySelectorAll('.candidate-checkbox')].map(cb => cb.value) : [];
                                ">
                            </th>
                            <th class="table-thead-th">{{ __('Name') }}</th>
                            <th class="table-thead-th">{{ __('Email') }}</th>
                            <th class="table-thead-th">{{ __('Active') }}</th>
                            <th class="table-thead-th">{{ __('Profile') }}</th>
                            <th class="table-thead-th">{{ __('Created At') }}</th>
                            <th class="table-thead-th table-thead-th-last">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($candidates as $candidate)
                        <tr class="table-tr">
                            <td class="table-td table-td-checkbox">
                                <input type="checkbox"
                                    class="candidate-checkbox form-checkbox h-4 w-4 text-primary"
                                    value="{{ $candidate->id }}"
                                    x-model="selectedCandidates">
                            </td>
                            <td class="table-td font-medium">{{ $candidate->first_name }} {{ $candidate->last_name }}</td>
                            <td class="table-td">{{ $candidate->email }}</td>
                            <td class="table-td">
                                {!! $candidate->is_active
                                ? '<span class="badge-success">Active</span>'
                                : '<span class="badge-danger">Inactive</span>' !!}
                            </td>
                            <td class="table-td">
                                {!! $candidate->is_profile_complete
                                ? '<span class="badge-info">Complete</span>'
                                : '<span class="badge-secondary">Incomplete</span>' !!}
                            </td>
                            <td class="table-td">
                                {{ $candidate->created_at->format('d M, Y') }}
                            </td>
                            <td class="table-td flex justify-center">
                                <x-buttons.action-buttons :label="__('Actions')" :show-label="false" align="right">
                                    @can('headhunters.candidates.view')
                                    <x-buttons.action-item
                                        :href="route('admin.headhunters.candidates.show', $candidate->id)"
                                        icon="eye" :label="__('View')" />
                                    @endcan
                                    @can('admin.headhunters.candidate.edit')
                                    <x-buttons.action-item
                                        :href="route('admin.headhunters.candidates.edit', $candidate->id)"
                                        icon="pencil" :label="__('Edit')" />
                                    @endcan
                                    @can('admin.headhunters.candidate.delete')
                                    <div x-data="{ deleteModalOpen: false }">
                                        <x-buttons.action-item
                                            type="modal-trigger"
                                            modal-target="deleteModalOpen"
                                            icon="trash"
                                            :label="__('Delete')"
                                            class="text-red-600" />

                                        <x-modals.confirm-delete
                                            id="delete-modal-{{ $candidate->id }}"
                                            title="{{ __('Delete Candidate') }}"
                                            content="{{ __('Are you sure you want to delete this candidate?') }}"
                                            formId="delete-form-{{ $candidate->id }}"
                                            formAction="{{ route('admin.headhunters.candidates.destroy', $candidate->id) }}"
                                            modalTrigger="deleteModalOpen"
                                            cancelButtonText="{{ __('No, cancel') }}"
                                            confirmButtonText="{{ __('Yes, delete') }}" />
                                    </div>
                                    @endcan
                                </x-buttons.action-buttons>
                            </td>
                        </tr>
                        @empty
                        <tr class="table-tr">
                            <td colspan="6" class="table-td text-center">
                                <span class="text-gray-500">{{ __('No candidates found') }}</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="my-4 px-4 sm:px-6">
                    {{ $candidates->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection