@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.forms.components._form._form-styles')
    @include('admin-page.forms.components._builder._builder-styles')
@endsection

@section('content')
    @include('admin-page.forms.components._builder._builder')
@endsection

@section('scripts')
    @include('admin-page.forms.components._builder._builder-scripts')
@endsection
