@extends('backend.layouts.app')

@section('title')
{{ __($breadcrumbs['title']) }} | {{ config('app.name') }}
@endsection

@section('admin-content')

<div class="p-4 mx-auto max-w-7xl md:p-6">
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Job Applications</h1>
    </div>

    @if (session('success'))
    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
        {{ session('error') }}
    </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-900">
        <div class="flex flex-col sm:flex-row items-center justify-between mb-4">
            <form action="{{ route('admin.headhunters.applications.index') }}" method="GET" class="w-full sm:w-1/2">
                <input type="text" name="search" placeholder="Search..." class="form-control" value="{{ request('search') }}">
            </form>
            <form id="bulk-delete-form" action="{{ route('admin.headhunters.applications.bulk-delete') }}" method="POST" class="mt-4 sm:mt-0">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-medium text-red-600 border border-red-600 rounded-lg hover:bg-red-50"
                    onclick="return confirm('Are you sure you want to delete selected applications?');">
                    Delete Selected
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left table-auto">
                <thead>
                    <tr class="text-gray-600 uppercase text-xs">
                        <th class="py-3 px-4">
                            <input type="checkbox" id="select-all" class="rounded">
                        </th>
                        <th class="py-3 px-4">Candidate</th>
                        <th class="py-3 px-4">Job Title</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Applied At</th>
                        <th class="py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach ($applications as $application)
                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <td class="py-3 px-4">
                            <input type="checkbox" name="ids[]" value="{{ $application->id }}" class="application-checkbox rounded">
                        </td>
                        <td class="py-3 px-4">{{ $application->candidate->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4">{{ $application->jobListing->job_title ?? 'N/A' }}</td>
                        <td class="py-3 px-4">{{ $application->status }}</td>
                        <td class="py-3 px-4">{{ $application->applied_at->format('d M Y') }}</td>
                        <td class="py-3 px-4 flex space-x-2">
                            <a href="{{ route('admin.headhunters.applications.show', $application->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            <form action="{{ route('admin.headhunters.applications.destroy', $application->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $applications->links() }}
        </div>
    </div>

</div>


@endsection