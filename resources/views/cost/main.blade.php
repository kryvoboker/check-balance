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

        <div class="costs-list"> {{-- //TODO: change it --}}
            <table class="table table-success table-striped">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">user_id</th>
                    <th scope="col">money_earned</th>
                    <th scope="col">current_month_day</th>
                    <th scope="col">next_month_day</th>
                    <th scope="col">costs</th>
                    <th scope="col">created_at</th>
                    <th scope="col">updated_at</th>
                </tr>
                </thead>
                <tbody>
                @forelse($costs_list as $cost)
                    <tr>
                        <th scope="row">{{ $cost->id }}</th>
                        <td>{{ $cost->user_id }}</td>
                        <td>{{ $cost->money_earned }}</td>
                        <td>{{ $cost->current_month_day }}</td>
                        <td>{{ $cost->next_month_day }}</td>
                        <td style="max-width: 200px; word-wrap: break-word">{{ $cost->costs }}</td>
                        <td>{{ $cost->created_at }}</td>
                        <td>{{ $cost->updated_at }}</td>
                    </tr>
                    {{--{!! $cost !!}--}}
                @empty
                    <div class="alert alert-info d-flex align-items-center gap-2">
                        <p class="m-0">{{ __('cost/main.empty_list') }}</p>

                        <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
                    </div>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
