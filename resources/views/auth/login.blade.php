@extends('layouts.main')

@section('title', __('user/login.title'))

@section('header')
@endsection

@section('content')
    <div class="login col-sm-6 col-12 mt-0 mb-0 ms-auto me-auto">
        <h1 class="fs-1 text-center mb-5">
            {{ __('user/login.heading_title') }}
        </h1>

        @if ($errors->any())
            <div class="alert alert-danger d-flex align-items-start gap-3">
                <ul class="m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

                <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form class="needs-validation d-flex flex-column" action="{{ route('login') }}"
              method="post" novalidate>
            @csrf

            <div class="mb-3 row">
                <label for="email" class="col-sm-3 col-form-label">
                    {{ __('user/login.email') }}
                </label>

                <div class="col-sm-8">
                    <input type="email" name="email" class="form-control" id="email" maxlength="255"
                           value="{{ old('email') }}"
                           pattern="^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$" required>

                    <div class="invalid-feedback">
                        {{ __('user/login.error_email') }}
                    </div>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="password" class="col-sm-3 col-form-label">
                    {{ __('user/login.password') }}
                </label>

                <div class="col-sm-8">
                    <input type="password" name="password" class="form-control" id="password"
                           minlength="3" maxlength="255" required>

                    <div class="invalid-feedback">
                        {{ __('user/login.error_password') }}
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column gap-3">
                <a href="{{ route('register') }}" class="link-primary">
                    {{ __('user/login.register') }}
                </a>

                <div class="col-12">
                    <button class="btn btn-primary" type="submit">
                        {{ __('user/login.submit') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
