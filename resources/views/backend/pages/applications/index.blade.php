@extends('backend.layouts.app')

@section('title')
{{ __($breadcrumbs['title']) }} | {{ config('app.name') }}
@endsection

@section('admin-content')
@php($itemType = $itemType ?? '')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6" x-data="{ selectedItems: [], selectAll: false, bulkDeleteModalOpen: false }">
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    {!! ld_apply_filters('items_list_after_breadcrumbs', '', $itemType) !!}

    <div class="space-y-6">
        <div class="rounded-md border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5 flex flex-col md:flex-row justify-between items-center gap-3">
                @include('backend.partials.search-form', [
                'placeholder' => __('Search'),
                ])

                <div class="flex items-center gap-3">
                    <!-- Dropdown Aksi Massal -->
                    <div class="relative flex items-center justify-center" x-show="selectedItems.length > 0" x-data="{ open: false }">
                        <button @click="open = !open" class="btn-secondary flex items-center justify-center gap-2 text-sm" type="button">
                            <iconify-icon icon="lucide:more-vertical"></iconify-icon>
                            <span>{{ __('Bulk Actions') }} (<span x-text="selectedItems.length"></span>)</span>
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

                    <!-- Dropdown Filter Status -->
                    <div class="relative flex items-center justify-center" x-data="{ open: false }">
                        <button @click="open = !open" class="btn-secondary flex items-center justify-center gap-2 text-sm" type="button">
                            <iconify-icon icon="lucide:filter"></iconify-icon>
                            <span class="hidden sm:inline">{{ __('Status') }}</span>
                            @if(request('status'))
                            <span class="px-2 py-0.5 text-xs bg-red-100 text-red-800 rounded-full dark:bg-red-900/20 dark:text-red-400">
                                {{ ucfirst(request('status')) }}
                            </span>
                            @endif
                            <iconify-icon icon="lucide:chevron-down"></iconify-icon>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 top-10 w-48 rounded-md shadow bg-white dark:bg-gray-700 z-10 p-2">
                            <ul class="space-y-2">
                                <li class="cursor-pointer text-sm text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 px-2 py-1.5 rounded {{ !request('status') ? 'bg-gray-200 dark:bg-gray-600' : '' }}"
                                    @click="open = false; window.location.href='{{ route('admin.headhunters.applications.index', ['search' => request('search')]) }}'">
                                    {{ __('Semua Status') }}
                                </li>
                                @foreach (['applied','in_review','interview','rejected','hired'] as $status)
                                <li class="cursor-pointer text-sm text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 px-2 py-1.5 rounded {{ $status === request('status') ? 'bg-gray-200 dark:bg-gray-600' : '' }}"
                                    @click="open = false; window.location.href='{{ route('admin.headhunters.applications.index', ['status' => $status, 'search' => request('search')]) }}'">
                                    {{ ucfirst($status) }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    @if (auth()->user()->can('item.create'))
                    <a href="{{ route('admin.headhunters.applications.create') }}" class="btn-primary flex items-center gap-2">
                        <iconify-icon icon="feather:plus" height="16"></iconify-icon>
                        {{ __("Item Baru") }}
                    </a>
                    @endif
                </div>
            </div>

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
                                            selectedItems = selectAll ?
                                                [...document.querySelectorAll('.item-checkbox')].map(cb => cb.value) :
                                                [];
                                        ">
                                </div>
                            </th>
                            <th width="30%" class="table-thead-th">
                                <div class="flex items-center">
                                    {{ __('Job Position') }}
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => request()->sort === 'title' ? '-title' : 'title']) }}" class="ml-1">
                                        @if(request()->sort === 'title')
                                        <iconify-icon icon="lucide:sort-asc" class="text-primary"></iconify-icon>
                                        @elseif(request()->sort === '-title')
                                        <iconify-icon icon="lucide:sort-desc" class="text-primary"></iconify-icon>
                                        @else
                                        <iconify-icon icon="lucide:arrow-up-down" class="text-gray-400"></iconify-icon>
                                        @endif
                                    </a>
                                </div>
                            </th>
                            <th width="15%" class="table-thead-th">{{ __('Candidate') }}</th>
                            <th width="10%" class="table-thead-th">
                                <div class="flex items-center">
                                    {{ __('Application Status') }}
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => request()->sort === 'status' ? '-status' : 'status']) }}" class="ml-1">
                                        @if(request()->sort === 'status')
                                        <iconify-icon icon="lucide:sort-asc" class="text-primary"></iconify-icon>
                                        @elseif(request()->sort === '-status')
                                        <iconify-icon icon="lucide:sort-desc" class="text-primary"></iconify-icon>
                                        @else
                                        <iconify-icon icon="lucide:arrow-up-down" class="text-gray-400"></iconify-icon>
                                        @endif
                                    </a>
                                </div>
                            </th>
                            <th width="10%" class="table-thead-th">
                                <div class="flex items-center">
                                    {{ __('Application Date') }}
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => request()->sort === 'created_at' ? '-created_at' : 'created_at']) }}" class="ml-1">
                                        @if(request()->sort === 'created_at')
                                        <iconify-icon icon="lucide:sort-asc" class="text-primary"></iconify-icon>
                                        @elseif(request()->sort === '-created_at')
                                        <iconify-icon icon="lucide:sort-desc" class="text-primary"></iconify-icon>
                                        @else
                                        <iconify-icon icon="lucide:arrow-up-down" class="text-gray-400"></iconify-icon>
                                        @endif
                                    </a>
                                </div>
                            </th>
                            <th width="15%" class="table-thead-th table-thead-th-last">{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $item)
                        <tr class="{{ $loop->index + 1 != count($applications) ? 'table-tr' : '' }}">
                            <td class="table-td table-td-checkbox">
                                <input
                                    type="checkbox"
                                    class="item-checkbox form-checkbox h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    value="{{ $item->id }}"
                                    x-model="selectedItems">
                            </td>
                            <td class="table-td">
                                <div class="flex gap-0.5 items-center">
                                    <div class="bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center mr-2 h-10 w-10 min-w-10">
                                        <iconify-icon icon="lucide:box" class=" text-center text-gray-400"></iconify-icon>
                                    </div>
                                    @if (auth()->user()->can('item.edit'))
                                    <a href="{{ route('admin.headhunters.applications.edit', $item->id) }}" class="text-gray-700 dark:text-white font-medium hover:text-primary dark:hover:text-primary">
                                        {{ optional($item->jobListing)->job_title ?? 'N/A' }}
                                    </a>
                                    @else
                                    {{ optional($item->jobListing)->job_title ?? 'N/A' }}
                                    @endif
                                </div>
                            </td>
                            <td class="table-td">
                                {{ optional($item->candidate)->first_name . ' ' . optional($item->candidate)->last_name ?? 'N/A' }}
                            </td>
                            <td class="table-td">
                                <span class="{{ get_post_status_class($item->status) }}">{{ ucfirst($item->status) }}</span>
                            </td>
                            <td class="table-td">
                                @if($item->applied_at)
                                <span
                                    class="cursor-help"
                                    title="{{ $item->applied_at->format('F d, Y \a\t g:i A') }}">
                                    {{ $item->applied_at->format('M d, Y') }}
                                </span>
                                @else
                                <span class="text-gray-500">N/A</span>
                                @endif
                            </td>
                            <td class="table-td flex justify-center">
                                <x-buttons.action-buttons :label="__('Actions')" :show-label="false" align="right">
                                    @if (auth()->user()->can('headhunters.applications.view'))
                                    <x-buttons.action-item
                                        :href="route('admin.headhunters.applications.show', $item->id)"
                                        icon="eye"
                                        :label="__('View')" />
                                    @endif
                                </x-buttons.action-buttons>
                            </td>
                        </tr>
                        @empty
                        <tr class="table-tr">
                            <td colspan="6" class="table-td text-center">
                                <span class="text-gray-500 dark:text-gray-300">{{ __('No') }} Data {{ __('found') }}</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="my-4 px-4 sm:px-6">
                    {{ $applications->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Massal -->
    <div
        x-cloak
        x-show="bulkDeleteModalOpen"
        x-transition.opacity.duration.200ms
        x-trap.inert.noscroll="bulkDeleteModalOpen"
        x-on:keydown.esc.window="bulkDeleteModalOpen = false"
        x-on:click.self="bulkDeleteModalOpen = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/20 p-4 backdrop-blur-md"
        role="dialog"
        aria-modal="true"
        aria-labelledby="bulk-delete-modal-title">
        <div
            x-show="bulkDeleteModalOpen"
            x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
            x-transition:enter-start="opacity-0 scale-50"
            x-transition:enter-end="opacity-100 scale-100"
            class="flex max-w-md flex-col gap-4 overflow-hidden rounded-md border border-outline border-gray-100 dark:border-gray-800 bg-white text-on-surface dark:border-outline-dark dark:bg-gray-700 dark:text-gray-300">
            <div class="flex items-center justify-between border-b border-gray-100 px-4 py-2 dark:border-gray-800">
                <div class="flex items-center justify-center rounded-full bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400 p-1">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h3 id="bulk-delete-modal-title" class="font-semibold tracking-wide text-gray-700 dark:text-white">
                    {{ __('Hapus Item Terpilih') }}
                </h3>
                <button
                    x-on:click="bulkDeleteModalOpen = false"
                    aria-label="close modal"
                    class="text-gray-400 hover:bg-gray-200 hover:text-gray-700 rounded-md p-1 dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="px-4 text-center">
                <p class="text-gray-500 dark:text-gray-300">
                    {{ __('Apakah Anda yakin ingin menghapus item yang dipilih?') }}
                    {{ __('Tindakan ini tidak bisa dibatalkan.') }}
                </p>
            </div>
            <div class="flex items-center justify-end gap-3 border-t border-gray-100 p-4 dark:border-gray-800">
                <form id="bulk-delete-form" action="{{ route('admin.headhunters.applications.bulk-delete') }}" method="POST">
                    @method('DELETE')
                    @csrf

                    <template x-for="id in selectedItems" :key="id">
                        <input type="hidden" name="ids[]" :value="id">
                    </template>

                    <button
                        type="button"
                        x-on:click="bulkDeleteModalOpen = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
                        {{ __('Tidak, Batalkan') }}
                    </button>

                    <button
                        type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-300 dark:focus:ring-red-800">
                        {{ __('Ya, Hapus') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection