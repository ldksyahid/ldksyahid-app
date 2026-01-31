@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.user.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.user.components._form._form', [
        'operation' => 'update',
        'user' => $user,
        'roles' => $roles,
        'currentRole' => $currentRole,
        'roleName' => null
    ])
@endsection

@section('scripts')
    @include('admin-page.user.components._form._form-scripts')
@endsection
