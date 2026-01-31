@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.news.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.news.components._form._form', [
        'operation' => 'update',
        'news' => $news
    ])
@endsection

@section('scripts')
    @include('admin-page.news.components._form._form-scripts')
@endsection
