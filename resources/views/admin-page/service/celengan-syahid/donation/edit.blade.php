@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.service.celengan-syahid.donation.components._form._form-styles')
@endsection

@section('content')
    @include('admin-page.service.celengan-syahid.donation.components._form._form', [
        'operation' => 'edit',
        'donation'  => $donation,
        'campaigns' => $campaigns,
    ])
@endsection

@section('scripts')
    @include('admin-page.service.celengan-syahid.donation.components._form._form-scripts')
@endsection
