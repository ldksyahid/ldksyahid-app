@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.schedule.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.schedule.components._form._form', [
        'operation' => 'update',
        'schedule' => $schedule
    ])
@endsection

@section('scripts')
    @include('admin-page.schedule.components._form._form-scripts')
@endsection
