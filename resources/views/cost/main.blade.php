@extends('layouts.main')

@section('header')
    <div class="container">
        <nav class="navbar bg-body-tertiary justify-content-end">
            <div class="main-actions">
                <a class="btn btn-outline-success create-cost" href="{{ route('costs.create') }}">
                    <i class="bi bi-plus-circle-fill"></i>

                    {{ __('cost/main.create_cost') }}
                </a>

                <button class="btn btn-outline-danger delete-cost" type="button">
                    <i class="bi bi-trash"></i>

                    {{ __('cost/main.delete_cost') }}
                </button>
            </div>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container">
        <h1>{{ __('cost/main.heading_title') }}</h1>

        <div class="costs-list">
            @forelse($costs_list as $cost)
                {!! $cost !!}
            @empty
                <div class="alert alert-info d-flex align-items-center gap-2">
                    <p class="m-0">{{ __('cost/main.empty_list') }}</p>

                    <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
                </div>
            @endforelse
        </div>
    </div>
@endsection
