@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.article.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.article.components._form._form', [
        'operation' => 'update',
        'article' => $article
    ])
@endsection

@section('scripts')
    @include('admin-page.article.components._form._form-scripts')
@endsection
