@extends('backend.layouts.app')

@section('title')
New Company | {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="p-4 mx-auto max-w-7xl md:p-6">
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />
    {!! ld_apply_filters('companies_create_after_breadcrumbs', '', 'company') !!}
    <form action="{{ route('admin.headhunters.companies.store') }}" method="POST" class="space-y-4">
        @csrf
        @include('backend.pages.companies.partials.form')
        <div class="mt-4">
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Save
            </button>
        </div>
    </form>
    {!! ld_apply_filters('after_company_form', '') !!}
</div>
@endsection