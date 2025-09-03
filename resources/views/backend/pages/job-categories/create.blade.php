@extends('backend.layouts.app')

@section('title')
{{ __($breadcrumbs['title']) }} | {{ config('app.name') }}
@endsection

@section('admin-content')

<div class="p-4 mx-auto max-w-4xl md:p-6">
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <form action="{{ route('admin.headhunters.job-categories.store') }}" method="POST" class="space-y-4">
        @csrf

        @include('backend.pages.job-categories.partials.form')

        <div class="mt-4">
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Save
            </button>
        </div>
    </form>

</div>
@endsection