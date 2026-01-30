@extends('admin-page.template.body')

@section('content')
    @include('admin-page.catalog-book.components._form._form', [
        'operation' => 'create',
        'book' => null,
        'titleForm' => 'Add New',
        'entityLabel' => 'Book',
        'languages' => $languages,
        'bookCategories' => $bookCategories,
        'authorTypes' => $authorTypes,
        'availabilityTypes' => $availabilityTypes,
    ])
@endsection

@section('styles')
    @include('admin-page.catalog-book.components._form._form-styles')
@endsection

@section('scripts')
    @include('admin-page.catalog-book.components._form._form-scripts')
@endsection