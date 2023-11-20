@extends('layouts.main')

@section('title', __(
            'cost/show.heading_title',
            ['start' => $cost_info->get('start_date'), 'end' => $cost_info->get('end_date')]
))

@section('content')
    <h1>
        {{ __(
            'cost/show.heading_title',
            ['start' => $cost_info->get('start_date'), 'end' => $cost_info->get('end_date')]
        ) }}
    </h1>
    <div class="container">
        @if($cost_info->has('dates')) {{-- //TODO: dev it --}}
        @foreach($cost_info->get('dates') as $date)
            <p>{{ $date }}</p>
        @endforeach()
        @else
            <div class="alert alert-danger">
                {{ __('cost/show.error_some_error_dates') }}
            </div>
        @endif
    </div>
@endsection
