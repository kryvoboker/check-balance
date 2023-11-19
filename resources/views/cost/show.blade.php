@extends('layouts.main')

@section('title', __('cost/show.heading_title'))

@section('content')
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
