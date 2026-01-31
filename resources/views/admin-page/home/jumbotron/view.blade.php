@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.home.jumbotron.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.home.jumbotron.components._form._form', [
        'operation' => 'view',
        'jumbotron' => $jumbotron
    ])
@endsection

@section('scripts')
    @include('admin-page.home.jumbotron.components._form._form-scripts')
@endsection
