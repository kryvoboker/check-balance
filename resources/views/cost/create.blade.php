@extends('layouts.main')

@section('title', __('cost/create.heading_title'))

@section('header')
    @parent

    <div class="container">
        <div class="header__top">
            <h1 class="fs-1">{{ __('cost/create.heading_title') }}</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger d-flex gap-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form class="d-flex flex-column gap-3 needs-validation costs__create-form" action="{{ route('costs.store') }}" method="post" novalidate>
            @csrf

            <div class="row gap-3 col-12">
                <div class="col-md-3 costs__create-item">
                    <label for="date-range" class="form-label d-flex justify-content-start align-items-start gap-1">
                    <span class="col-md-8">
                        {{ __('cost/create.text_date_range') }}
                    </span>
                        <button type="button" class="btn btn-secondary costs__create-help" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="{{ __('cost/create.text_date_range_help') }}">
                            <i class="bi bi-question-circle"></i>
                        </button>
                    </label>

                    <input class="form-control"
                           value="{{ old('date_range') }}"
                           name="date_range" type="text" id="date-range" required>
                    <div class="invalid-feedback">
                        {{ __('cost/create.error_date_range') }}
                    </div>
                </div>

                <div class="col-md-3 costs__create-item">
                    <label for="income-funds" class="form-label d-flex justify-content-start align-items-start gap-1">
                        {{ __('cost/create.text_income_funds') }}
                    </label>

                    <input class="form-control"
                           value="{{ old('income_funds') }}"
                           type="number" name="income_funds" id="income-funds" required>
                    <div class="invalid-feedback">
                        {{ __('cost/create.error_income_funds') }}
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column gap-3 col-12 add-dreams">
                <button type="button" class="btn btn-warning costs__add-dreams-btn col-2">
                    <i class="bi bi-plus-circle"></i>
                    <span class="ms-2">
                        {{ __('cost/create.text_add_dreams_btn') }}
                    </span>
                </button>
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">
                    {{ __('cost/create.text_save') }}
                </button>
            </div>
        </form>
    </div>

    <div class="d-none row gap-3 mb-3 add-dreams-prototype">
        <div class="row">
            <label class="col-sm-2 col-form-label" for="dream-name">
                {{ __('cost/create.text_dream_name') }}
            </label>

            <div class="col-sm-3">
                <input class="form-control" type="text" name="dream[name][]" id="dream-name" required>

                <div class="invalid-feedback">
                    {{ __('cost/create.error_dream_name') }}
                </div>
            </div>
        </div>

        <div class="row">
            <label class="col-sm-2 col-form-label" for="dream-total">
                {{ __('cost/create.text_dream_total') }}
            </label>

            <div class="col-sm-3">
                <input class="form-control" type="number" name="dream[total][]" id="dream-total" required>

                <div class="invalid-feedback">
                    {{ __('cost/create.error_dream_total') }}
                </div>
            </div>
        </div>

        <hr/>
    </div>
@endsection
