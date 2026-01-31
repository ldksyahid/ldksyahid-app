@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.service.call-kestari.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.service.call-kestari.components._form._form', [
        'operation' => 'update',
        'callKestari' => $callKestari,
        'titleForm' => 'Edit',
        'entityLabel' => 'Call Kestari'
    ])
@endsection

@section('scripts')
    @include('admin-page.service.call-kestari.components._form._form-scripts')
@endsection
