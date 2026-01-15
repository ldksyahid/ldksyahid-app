@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.about.management-structure.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.about.management-structure.components._form._form', [
        'operation' => 'create',
        'structure' => null
    ])
@endsection

@section('scripts')
    @include('admin-page.about.management-structure.components._form._form-scripts')
@endsection
