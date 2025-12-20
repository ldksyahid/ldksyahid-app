@extends('admin-page.template.body')

@section('content')
    <x-finance-report.form
        operation="create"
        titleForm="Add New"
        entityLabel="Finance Report"
        :ldkTags="$ldkTags"
    />
@endsection

@section('styles')
    @include('admin-page.finance-report.components._form._form-styles')
@endsection

@section('scripts')
    @include('admin-page.finance-report.components._form._form-scripts')
@endsection
