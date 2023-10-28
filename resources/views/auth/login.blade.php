@extends('layouts.main')

@section('title', __('login/login.title'))

@section('header')
@endsection

@section('content')
    <form class="needs-validation d-flex flex-column" action="{{ route('login') }}" method="post" novalidate>
        @csrf

        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">
                {{ __('login/login.email') }}
            </label>

            <div class="col-sm-10">
                <input type="email" name="email" class="form-control" id="email" maxlength="255"
                pattern="^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$" required>

                <div class="invalid-feedback">
                    {{ __('login/login.error_email') }}
                </div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">
                {{ __('login/login.password') }}
            </label>

            <div class="col-sm-10">
                <input type="password" name="password" class="form-control" id="password"
                       minlength="3" maxlength="255" required>

                <div class="invalid-feedback">
                    {{ __('login/login.error_password') }}
                </div>
            </div>
        </div>

        <div class="col-12">
            <button class="btn btn-primary" type="submit">
                {{ __('login/login.submit') }}
            </button>
        </div>
    </form>
@endsection
