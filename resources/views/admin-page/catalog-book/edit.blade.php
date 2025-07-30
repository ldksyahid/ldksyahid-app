@extends('admin-page.template.body')

@section('content')
    <x-catalog-book.form operation="update" :book="$book" titleForm="Edit Book:" entityLabel="{{ $book->titleBook }}"/>
@endsection

@section('styles')
    @include('admin-page.catalog-book.components._form-styles')
@endsection

@section('scripts')
    @include('admin-page.catalog-book.components._form-scripts')
@endsection
