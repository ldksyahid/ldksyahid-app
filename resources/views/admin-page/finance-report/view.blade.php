@extends('admin-page.template.body')

@section('content')
    @include('admin-page.finance-report.components._form._form', [
        'operation' => 'view',
        'financeReport' => $financeReport,
        'titleForm' => 'View',
        'entityLabel' => 'Finance Report',
        'ldkTags' => $ldkTags,
    ])
@endsection

@section('styles')
    @include('admin-page.finance-report.components._form._form-styles')
@endsection

@section('scripts')
    @include('admin-page.finance-report.components._form._form-scripts')
@endsection
