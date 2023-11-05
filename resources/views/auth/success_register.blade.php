@extends('layouts.main')

@section('title', __('user/register.success'))

@section('header')
@endsection

@section('content')
    <div class="col-sm-8 col-12 mt-0 mb-0 ms-auto me-auto d-flex flex-column align-items-center">
        <h1 class="fs-1 text-center mb-5">{{ __('user/register.success') }}</h1>

        <a class="btn btn-primary mb-4" href="{{ route('login') }}" role="button">
            {{ __('user/register.login_in_account') }}
        </a>

        <img class="img-fluid"
             src="{{ asset('storage/image/register/success.jpg') }}"
             srcset="{{ asset('storage/image/register/success.webp') }}"
             width="965" height="360"
             loading="eager"
             alt="{{ __('user/register.success') }}">
    </div>
@endsection

@section('footer')
@endsection
