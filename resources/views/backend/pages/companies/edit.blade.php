@extends('backend.layouts.app')

@section('title')
Edit Company | {{ config('app.name') }}
@endsection

@section('admin-content')

<div class="p-4 mx-auto max-w-7xl md:p-6">
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    {!! ld_apply_filters('companies_edit_after_breadcrumbs', '', 'company') !!}

    <form action="{{ route('admin.headhunters.companies.update', $company->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        @include('backend.pages.companies.partials.form', ['company' => $company, 'users' => $users])

        <div class="mt-4">
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Update
            </button>
            <a href="{{ route('admin.headhunters.companies.index') }}" class="ml-2 px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100">
                Cancel
            </a>
        </div>
    </form>
    {!! ld_apply_filters('after_company_form', '') !!}

</div>
@endsection