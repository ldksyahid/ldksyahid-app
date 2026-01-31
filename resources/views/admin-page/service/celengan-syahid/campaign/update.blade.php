@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.service.celengan-syahid.campaign.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.service.celengan-syahid.campaign.components._form._form', [
        'operation' => 'update',
        'data' => $data,
        'provinces' => $province ?? collect()
    ])
@endsection

@section('scripts')
    @include('admin-page.service.celengan-syahid.campaign.components._form._form-scripts')
@endsection
