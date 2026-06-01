@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.comment.components._view._view-styles')
@endsection

@section('content')
    @include('admin-page.comment.components._view._view', ['comment' => $comment])
@endsection

@section('scripts')
    @include('admin-page.comment.components._view._view-scripts', ['comment' => $comment])
@endsection
