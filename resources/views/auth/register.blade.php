@extends('layouts.main')

@section('title', __('user/register.title'))

@section('header')
@endsection

@section('content')
    <div class="container">
        <div class="login col-sm-6 col-12 mt-0 mb-0 ms-auto me-auto">
            <h1 class="fs-1 text-center mb-5">
                {{ __('user/register.heading_title') }}
            </h1>

            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-start gap-3">
                    <ul class="m-0">
                        @foreach($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>

                    <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form class="needs-validation d-flex flex-column" action="{{ route('register') }}"
                  method="post" novalidate>

                @csrf

                <div class="mb-3 row">
                    <label for="name" class="col-sm-3 col-form-label">
                        {{ __('user/register.name') }}
                    </label>

                    <div class="col-sm-8">
                        <input type="text" name="name" class="form-control" id="name" minlength="3" maxlength="255"
                               value="{{ old('name') }}" required>

                        <div class="invalid-feedback">
                            {{ __('user/register.error_name') }}
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="lastname" class="col-sm-3 col-form-label">
                        {{ __('user/register.lastname') }}
                    </label>

                    <div class="col-sm-8">
                        <input type="text" name="lastname" class="form-control" id="lastname" minlength="3"
                               maxlength="255"
                               value="{{ old('lastname') }}" required>

                        <div class="invalid-feedback">
                            {{ __('user/register.error_lastname') }}
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-sm-3 col-form-label">
                        {{ __('user/register.email') }}
                    </label>

                    <div class="col-sm-8">
                        <input type="email" name="email" class="form-control" id="email" maxlength="255"
                               value="{{ old('email') }}"
                               pattern="^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$" required>

                        <div class="invalid-feedback">
                            {{ __('user/register.error_email') }}
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="telephone" class="col-sm-3 col-form-label">
                        {{ __('user/register.telephone') }}
                    </label>

                    <div class="col-sm-8">
                        <input type="tel" name="telephone" class="form-control" id="telephone" maxlength="255"
                               value="{{ old('telephone') }}"
                               pattern="(^((\+?\d{2,}\s?)|(.*))\(?\d{3,}\)?\s?\d{3,}-?\d{2,}-?\d{2,}$)" required>

                        <div class="invalid-feedback">
                            {{ __('user/register.error_telephone') }}
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="password" class="col-sm-3 col-form-label">
                        {{ __('user/register.password') }}
                    </label>

                    <div class="col-sm-8">
                        <input type="password" name="password" class="form-control" id="password"
                               minlength="3" maxlength="255" required>

                        <div class="invalid-feedback">
                            {{ __('user/register.error_password') }}
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="password_confirmation" class="col-sm-3 col-form-label">
                        {{ __('user/register.password_confirmation') }}
                    </label>

                    <div class="col-sm-8">
                        <input type="password" name="password_confirmation" class="form-control"
                               id="password_confirmation"
                               minlength="3" maxlength="255" required>

                        <div class="invalid-feedback">
                            {{ __('user/register.error_password_confirmation') }}
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column gap-3">
                    <a href="{{ route('login') }}" class="link-primary">
                        {{ __('user/register.have_account') }}
                    </a>

                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">
                            {{ __('user/register.submit') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
@endsection
