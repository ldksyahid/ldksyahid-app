@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.event.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.event.components._form._form', [
        'operation' => 'view',
        'event' => $event,
        'titleForm' => 'Preview',
        'entityLabel' => 'Event'
    ])
@endsection

@section('scripts')
    @include('admin-page.event.components._form._form-scripts')
@endsection
