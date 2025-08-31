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
                'placeholder' => __('Search by company name or email'),
                ])

                <div class="flex items-center gap-3">
                    {{-- Bulk Actions --}}
                    <div class="relative" x-show="selectedCompanies.length > 0" x-data="{ open: false }">
                        <button @click="open = !open" class="btn-secondary flex items-center gap-2 text-sm">
                            <iconify-icon icon="lucide:more-vertical"></iconify-icon>
                            <span>{{ __('Bulk Actions') }} (<span x-text="selectedCompanies.length"></span>)</span>
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
                            @if(request('is_active'))
                            <span class="px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded-full">
                                {{ request('is_active') ? __('Active') : __('Inactive') }}
                            </span>
                            @endif
                            <iconify-icon icon="lucide:chevron-down"></iconify-icon>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 top-10 w-48 rounded-md shadow bg-white dark:bg-gray-700 z-10 p-2">
                            <ul>
                                <li class="cursor-pointer text-sm px-2 py-1.5 rounded {{ !request('is_active') ? 'bg-gray-200' : '' }}"
                                    @click="window.location.href='{{ route('admin.headhunters.companies.index', array_merge(request()->except('is_active'))) }}'">
                                    {{ __('All') }}
                                </li>
                                <li class="cursor-pointer text-sm px-2 py-1.5 rounded {{ request('is_active') == 1 ? 'bg-gray-200' : '' }}"
                                    @click="window.location.href='{{ route('admin.headhunters.companies.index', array_merge(request()->all(), ['is_active' => 1])) }}'">
                                    {{ __('Active') }}
                                </li>
                                <li class="cursor-pointer text-sm px-2 py-1.5 rounded {{ request('is_active') == 0 ? 'bg-gray-200' : '' }}"
                                    @click="window.location.href='{{ route('admin.headhunters.companies.index', array_merge(request()->all(), ['is_active' => 0])) }}'">
                                    {{ __('Inactive') }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Add New --}}
                    @can('headhunters.companies.create')
                    <a href="{{ route('admin.headhunters.companies.create') }}" class="btn-primary flex items-center gap-2">
                        <iconify-icon icon="feather:plus" height="16"></iconify-icon>
                        {{ __('New Company') }}
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
                                <div class="flex items-center">
                                    <input
                                        type="checkbox"
                                        class="form-checkbox h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        x-model="selectAll"
                                        @click="
                                selectAll = !selectAll;
                                selectedCompanies = selectAll ? 
                                    [...document.querySelectorAll('.company-checkbox')].map(cb => cb.value) : [];
                            ">
                                </div>
                            </th>
                            <th class="table-thead-th">{{ __('Company Name') }}</th>
                            <th class="table-thead-th">{{ __('Contact Person') }}</th>
                            <th class="table-thead-th">{{ __('Email') }}</th>
                            <th class="table-thead-th">{{ __('Phone') }}</th>
                            <th class="table-thead-th">{{ __('Status') }}</th>
                            <th class="table-thead-th">{{ __('Created At') }}</th>
                            <th class="table-thead-th table-thead-th-last">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($companies as $company)
                        <tr class="{{ $loop->index + 1 != count($companies) ? 'table-tr' : '' }}">
                            <td class="table-td table-td-checkbox">
                                <input
                                    type="checkbox"
                                    value="{{ $company->id }}"
                                    class="company-checkbox form-checkbox h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    x-model="selectedCompanies">
                            </td>
                            <td class="table-td">{{ $company->company_name }}</td>
                            <td class="table-td">{{ $company->contact_person_name }}</td>
                            <td class="table-td">{{ $company->contact_person_email }}</td>
                            <td class="table-td">{{ $company->contact_person_phone }}</td>
                            <td class="table-td">
                                <span class="badge {{ $company->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $company->is_active ? __('Active') : __('Inactive') }}
                                </span>
                            </td>
                            <td class="table-td">
                                <span class="cursor-help" title="{{ $company->created_at->format('F d, Y \a\t g:i A') }}">
                                    {{ $company->created_at->format('M d, Y') }}
                                </span>
                            </td>
                            <td class="table-td flex justify-center">
                                <x-buttons.action-buttons :label="__('Actions')" :show-label="false" align="right">
                                    @can('headhunters.companies.edit')
                                    <x-buttons.action-item
                                        :href="route('admin.headhunters.companies.edit', $company->id)"
                                        icon="pencil"
                                        :label="__('Edit')" />
                                    @endcan

                                    @can('headhunters.companies.view')
                                    <x-buttons.action-item
                                        :href="route('admin.headhunters.companies.show', $company->id)"
                                        icon="eye"
                                        :label="__('View')" />
                                    @endcan

                                    @can('headhunters.companies.delete')
                                    <div x-data="{ deleteModalOpen: false }">
                                        <x-buttons.action-item
                                            type="modal-trigger"
                                            modal-target="deleteModalOpen"
                                            icon="trash"
                                            :label="__('Delete')"
                                            class="text-red-600 dark:text-red-400" />

                                        <x-modals.confirm-delete
                                            id="delete-modal-{{ $company->id }}"
                                            title="{{ __('Delete Company') }}"
                                            content="{{ __('Are you sure you want to delete this company?') }}"
                                            formId="delete-form-{{ $company->id }}"
                                            formAction="{{ route('admin.headhunters.companies.destroy', $company->id) }}"
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
                            <td colspan="8" class="table-td text-center">
                                <span class="text-gray-500 dark:text-gray-300">{{ __('No companies found.') }}</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="my-4 px-4 sm:px-6">
                    {{ $companies->links() }}
                </div>
            </div>

        </div>
    </div>

    {{-- Bulk Delete Modal --}}
    <div x-cloak x-show="bulkDeleteModalOpen" class="fixed inset-0 flex items-center justify-center bg-black/20 z-50">
        <div class="bg-white rounded shadow-md p-6 w-full max-w-md">
            <h2 class="text-lg font-bold">{{ __('Delete Selected Companies') }}</h2>
            <p class="text-gray-600">{{ __('Are you sure you want to delete the selected companies? This action cannot be undone.') }}</p>

            <form id="bulk-delete-form" action="{{ route('admin.headhunters.companies.bulk-delete') }}" method="POST" class="mt-4 flex justify-end gap-3">
                @csrf @method('DELETE')
                <template x-for="id in selectedCompanies" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <button type="button" @click="bulkDeleteModalOpen = false" class="btn-secondary">{{ __('Cancel') }}</button>
                <button type="submit" class="btn-danger">{{ __('Delete') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection