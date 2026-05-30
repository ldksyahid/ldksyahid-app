@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.forms.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.forms.components._form._form', ['operation' => 'edit', 'form' => $form])
@endsection

@section('scripts')
    @include('admin-page.forms.components._form._form-scripts')
@endsection
