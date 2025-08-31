@extends('backend.layouts.app')

@section('title')
{{ __($breadcrumbs['title']) }} | {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6"
    x-data="{ selectedJobs: [], selectAll: false, bulkDeleteModalOpen: false }">

    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <div class="space-y-6">
        <div class="rounded-md border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5 flex flex-col md:flex-row justify-between items-center gap-3">

                {{-- Search --}}
                @include('backend.partials.search-form', [
                'placeholder' => __('Search by job title or company'),
                ])

                <div class="flex items-center gap-3">
                    {{-- Bulk Actions --}}
                    <div class="relative" x-show="selectedJobs.length > 0" x-data="{ open: false }">
                        <button @click="open = !open" class="btn-secondary flex items-center gap-2 text-sm">
                            <iconify-icon icon="lucide:more-vertical"></iconify-icon>
                            <span>{{ __('Bulk Actions') }} (<span x-text="selectedJobs.length"></span>)</span>
                            <iconify-icon icon="lucide:chevron-down"></iconify-icon>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 top-10 w-48 rounded-md shadow bg-white dark:bg-gray-700 z-10 p-2">
                            <ul>
                                <li class="cursor-pointer flex items-center gap-1 text-sm text-red-600 dark:text-red-500 hover:bg-red-50 px-2 py-1.5 rounded"
                                    @click="open = false; bulkDeleteModalOpen = true">
                                    <iconify-icon icon="lucide:trash"></iconify-icon> {{ __('Delete Selected') }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Status filter --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="btn-secondary flex items-center gap-2 text-sm">
                            <iconify-icon icon="lucide:filter"></iconify-icon>
                            <span>{{ __('Status') }}</span>
                            @if(request('is_open'))
                            <span class="px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded-full">
                                {{ request('is_open') ? __('Open') : __('Closed') }}
                            </span>
                            @endif
                            <iconify-icon icon="lucide:chevron-down"></iconify-icon>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 top-10 w-48 rounded-md shadow bg-white dark:bg-gray-700 z-10 p-2">
                            <ul>
                                <li class="cursor-pointer text-sm px-2 py-1.5 rounded {{ !request('is_open') ? 'bg-gray-200' : '' }}"
                                    @click="window.location.href='{{ route('admin.headhunters.jobs.index', array_merge(request()->except('is_open'))) }}'">
                                    {{ __('All') }}
                                </li>
                                <li class="cursor-pointer text-sm px-2 py-1.5 rounded {{ request('is_open') == 1 ? 'bg-gray-200' : '' }}"
                                    @click="window.location.href='{{ route('admin.headhunters.jobs.index', array_merge(request()->all(), ['is_open' => 1])) }}'">
                                    {{ __('Open') }}
                                </li>
                                <li class="cursor-pointer text-sm px-2 py-1.5 rounded {{ request('is_open') == 0 ? 'bg-gray-200' : '' }}"
                                    @click="window.location.href='{{ route('admin.headhunters.jobs.index', array_merge(request()->all(), ['is_open' => 0])) }}'">
                                    {{ __('Closed') }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Add New --}}
                    @can('headhunters.jobs.create')
                    <a href="{{ route('admin.headhunters.jobs.create') }}" class="btn-primary flex items-center gap-2">
                        <iconify-icon icon="feather:plus" height="16"></iconify-icon>
                        {{ __('New Job') }}
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
                                <input type="checkbox"
                                    class="form-checkbox h-4 w-4 text-primary border-gray-300 rounded"
                                    x-model="selectAll"
                                    @click="
                                        selectAll = !selectAll;
                                        selectedJobs = selectAll ? 
                                            [...document.querySelectorAll('.job-checkbox')].map(cb => cb.value) : [];
                                    ">
                            </th>
                            <th class="table-thead-th">{{ __('Job Title') }}</th>
                            <th class="table-thead-th">{{ __('Company') }}</th>
                            <th class="table-thead-th">{{ __('Category') }}</th>
                            <th class="table-thead-th">{{ __('Location') }}</th>
                            <th class="table-thead-th">{{ __('Status') }}</th>
                            <th class="table-thead-th">{{ __('Featured') }}</th>
                            <th class="table-thead-th">{{ __('Expires') }}</th>
                            <th class="table-thead-th table-thead-th-last">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobs as $job)
                        <tr class="{{ $loop->index + 1 != count($jobs) ? 'table-tr' : '' }}">
                            <td class="table-td table-td-checkbox">
                                <input type="checkbox"
                                    value="{{ $job->id }}"
                                    class="job-checkbox form-checkbox h-4 w-4 text-primary border-gray-300 rounded"
                                    x-model="selectedJobs">
                            </td>
                            <td class="table-td">{{ $job->job_title }}</td>
                            <td class="table-td">{{ $job->company?->company_name ?? '-' }}</td>
                            <td class="table-td">{{ $job->category?->name ?? '-' }}</td>
                            <td class="table-td">{{ $job->city }}, {{ $job->country }}</td>
                            <td class="table-td">
                                <span class="badge {{ $job->is_open ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $job->is_open ? __('Open') : __('Closed') }}
                                </span>
                            </td>
                            <td class="table-td">
                                <span class="badge {{ $job->is_featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $job->is_featured ? __('Featured') : __('Normal') }}
                                </span>
                            </td>
                            <td class="table-td">{{ $job->expires_at?->format('M d, Y') ?? '-' }}</td>
                            <td class="table-td flex justify-center">
                                <x-buttons.action-buttons :label="__('Actions')" :show-label="false" align="right">
                                    @can('headhunters.jobs.edit')
                                    <x-buttons.action-item :href="route('admin.headhunters.jobs.edit', $job->id)" icon="pencil" :label="__('Edit')" />
                                    @endcan

                                    @can('headhunters.jobs.view')
                                    <x-buttons.action-item :href="route('admin.headhunters.jobs.show', $job->id)" icon="eye" :label="__('View')" />
                                    @endcan

                                    @can('headhunters.jobs.delete')
                                    <div x-data="{ deleteModalOpen: false }">
                                        <x-buttons.action-item type="modal-trigger" modal-target="deleteModalOpen"
                                            icon="trash" :label="__('Delete')" class="text-red-600 dark:text-red-400" />

                                        <x-modals.confirm-delete
                                            id="delete-modal-{{ $job->id }}"
                                            title="{{ __('Delete Job') }}"
                                            content="{{ __('Are you sure you want to delete this job?') }}"
                                            formId="delete-form-{{ $job->id }}"
                                            formAction="{{ route('admin.headhunters.jobs.destroy', $job->id) }}"
                                            modalTrigger="deleteModalOpen"
                                            cancelButtonText="{{ __('No, cancel') }}"
                                            confirmButtonText="{{ __('Yes, Confirm') }}" />
                                    </div>
                                    @endcan
                                </x-buttons.action-buttons>
                            </td>
                        </tr>
                        @empty
                        <tr class="table-tr">
                            <td colspan="9" class="table-td text-center">
                                <span class="text-gray-500 dark:text-gray-300">{{ __('No jobs found.') }}</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="my-4 px-4 sm:px-6">
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Bulk Delete Modal --}}
    <div x-cloak x-show="bulkDeleteModalOpen" class="fixed inset-0 flex items-center justify-center bg-black/20 z-50">
        <div class="bg-white rounded shadow-md p-6 w-full max-w-md">
            <h2 class="text-lg font-bold">{{ __('Delete Selected Jobs') }}</h2>
            <p class="text-gray-600">{{ __('Are you sure you want to delete the selected jobs? This action cannot be undone.') }}</p>

            <form id="bulk-delete-form" action="{{ route('admin.headhunters.jobs.bulk-delete') }}" method="POST" class="mt-4 flex justify-end gap-3">
                @csrf @method('DELETE')
                <template x-for="id in selectedJobs" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <button type="button" @click="bulkDeleteModalOpen = false" class="btn-secondary">{{ __('Cancel') }}</button>
                <button type="submit" class="btn-danger">{{ __('Delete') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection