@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.service-request.short-link.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.service-request.short-link.components._form._form', [
        'operation' => 'update',
        'reqshortlink' => $reqshortlink
    ])
@endsection

@section('scripts')
    @include('admin-page.service-request.short-link.components._form._form-scripts')
@endsection
