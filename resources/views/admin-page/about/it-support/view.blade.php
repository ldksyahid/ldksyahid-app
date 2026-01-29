@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.about.it-support.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.about.it-support.components._form._form', [
        'operation' => 'view',
        'itsupport' => $itsupport
    ])
@endsection

@section('scripts')
    @include('admin-page.about.it-support.components._form._form-scripts')
@endsection
