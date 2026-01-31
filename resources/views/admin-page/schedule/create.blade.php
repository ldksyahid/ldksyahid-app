@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.schedule.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.schedule.components._form._form', [
        'operation' => 'create',
        'schedule' => null
    ])
@endsection

@section('scripts')
    @include('admin-page.schedule.components._form._form-scripts')
@endsection
