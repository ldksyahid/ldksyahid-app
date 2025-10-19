@extends('admin-page.template.body')

@section('content')
    <x-catalog-book.form 
        operation="update" 
        :book="$book" 
        titleForm="Edit Book:" 
        entityLabel="{{ $book->titleBook }}"
        :languages="$languages"
    />
@endsection

@section('styles')
    @include('admin-page.catalog-book.components._form._form-styles')
@endsection

@section('scripts')
    @include('admin-page.catalog-book.components._form._form-scripts')
@endsection