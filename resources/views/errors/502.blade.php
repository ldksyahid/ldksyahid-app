@extends('errors.layout')

@section('title', 'Bad Gateway')
@section('code', '502')
@section('icon', 'fas fa-network-wired')
@section('emoji', '🌐')
@section('heading', 'Bad Gateway')
@section('description', 'Server menerima respons yang tidak valid dari server upstream. Silakan coba lagi dalam beberapa saat.')
