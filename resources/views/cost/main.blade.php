@extends('layouts.main')

@section('title', __('cost/main.heading_title'))

@section('content')
    <div class="container">
        <h1>{{ __('cost/main.heading_title') }}</h1>

        @if(session()->has('success_destroy_cost'))
            <div class="alert alert-success">
                <span>{!! session()->get('success_destroy_cost') !!}</span>
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="costs-list"> {{-- //TODO: change it --}}
            <table class="table table-success table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col">
                        {{ __('cost/main.text_cost_id') }}
                    </th>
                    <th scope="col">user_id</th> {{--//TODO: remove it in production--}}
                    <th scope="col">
                        {{ __('cost/main.text_money_earned') }}
                    </th>
                    <th scope="col">
                        {{ __('cost/main.text_current_month_day') }}
                    </th>
                    <th scope="col">
                        {{ __('cost/main.text_next_month_day') }}
                    </th>
                    <th scope="col">
                        {{ __('cost/main.text_edit_view_cost') }}
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse($costs_list as $cost)
                    <tr>
                        <th scope="row">{{ $cost->id }}</th>
                        <td>{{ $cost->user_id }}</td>
                        <td>{{ $cost->money_earned }}</td>
                        <td>{{ $cost->start_month_day }}</td>
                        <td>{{ $cost->next_month_day }}</td>
                        <td>
                            <a class="btn btn-warning" href="{{ route('costs.edit', ['cost' => $cost->id]) }}">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="{{ route('costs.show', ['cost' => $cost->id]) }}" class="btn btn-info">
                                <i class="bi bi-box-arrow-in-down-right"></i>
                            </a>
                        </td>
                    </tr>
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
