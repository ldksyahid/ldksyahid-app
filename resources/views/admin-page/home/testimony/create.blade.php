@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.home.testimony.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.home.testimony.components._form._form', [
        'operation' => 'create',
        'testimony' => null
    ])
@endsection

@section('scripts')
    @include('admin-page.home.testimony.components._form._form-scripts')
@endsection
