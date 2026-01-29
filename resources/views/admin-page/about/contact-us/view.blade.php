@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.about.contact-us.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.about.contact-us.components._form._form', [
        'operation' => 'view',
        'data' => $data
    ])
@endsection

@section('scripts')
    @include('admin-page.about.contact-us.components._form._form-scripts')
@endsection
