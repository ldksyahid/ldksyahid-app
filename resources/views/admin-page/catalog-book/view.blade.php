@extends('admin-page.template.body')

@section('content')
    <x-catalog-book.form operation="view" :book="$book" titleForm="View Book:" entityLabel="{{ $book->titleBook }}"/>
@endsection

@section('styles')
    @include('admin-page.catalog-book.components._form-styles')
@endsection
