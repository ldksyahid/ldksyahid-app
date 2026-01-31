@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.kta-ldksyahid.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.kta-ldksyahid.components._form._form', [
        'operation' => 'create',
        'ktaData' => null,
        'facultyModel' => $facultyModel,
        'generationModel' => $generationModel
    ])
@endsection

@section('scripts')
    @include('admin-page.kta-ldksyahid.components._form._form-scripts')
@endsection
