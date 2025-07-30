@extends('admin-page.template.body')

@section('content')
    <x-catalog-book.form operation="create" titleForm="Add New" entityLabel="Book"/>
@endsection

@section('styles')
    @include('admin-page.catalog-book.components._form-styles')
@endsection

@section('scripts')
    @include('admin-page.catalog-book.components._form-scripts')
@endsection
