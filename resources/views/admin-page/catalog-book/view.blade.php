@extends('admin-page.template.body')

@section('content')
    <x-catalog-book.form 
        operation="view" 
        :book="$book" 
        titleForm="View Book:" 
        entityLabel="{{ $book->titleBook }}"
        :languages="$languages"
        :bookCategories="$bookCategories"
        :authorTypes="$authorTypes"
        :availabilityTypes="$availabilityTypes"
    />
@endsection

@section('styles')
    @include('admin-page.catalog-book.components._form._form-styles')
@endsection

@section('scripts')
    @include('admin-page.catalog-book.components._form._form-scripts')
@endsection