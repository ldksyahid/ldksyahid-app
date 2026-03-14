@extends('errors.layout')

@section('title', 'Terjadi Kesalahan')
@section('code', isset($exception) && method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 'Oops')
@section('icon', 'fas fa-exclamation-triangle')
@section('heading', 'Terjadi Kesalahan')
@section('description', isset($exception) && $exception->getMessage() ? $exception->getMessage() : 'Maaf, terjadi kesalahan yang tidak terduga. Silakan coba lagi atau kembali ke beranda.')
