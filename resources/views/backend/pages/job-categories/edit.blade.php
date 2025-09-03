@extends('backend.layouts.app')

@section('title')
{{ __($breadcrumbs['title']) }} | {{ config('app.name') }}
@endsection

@section('admin-content')

<div class="p-4 mx-auto max-w-4xl md:p-6">
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <form action="{{ route('admin.headhunters.job-categories.update', $category->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        @include('backend.pages.job-categories.partials.form', ['category' => $category])

        <div class="mt-4">
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Update
            </button>
            <a href="{{ route('admin.headhunters.job-categories.index') }}" class="ml-2 px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100">
                Cancel
            </a>
        </div>
    </form>

</div>
@endsection