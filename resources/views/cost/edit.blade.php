@extends('layouts.main')

@section('title', __(
            'cost/edit.heading_title',
            ['start' => $cost_info->get('start_date'), 'end' => $cost_info->get('end_date')]
))

@section('content')
    <div class="container">
        <h1 class="mb-5">
            {{ __(
                'cost/edit.heading_title',
                ['start' => $cost_info->get('start_date'), 'end' => $cost_info->get('end_date')]
            ) }}
        </h1>

        @if($errors->any())
            <div class="alert alert-danger d-flex gap-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form class="needs-validation" action="{{ route('costs.update', ['cost' => $cost_id]) }}"
              method="post" id="edit-cost-form" novalidate>
            @csrf
            @method('PUT')

            <div class="edit-costs-list">
                @if($cost_info->has('dates'))
                    <table class="table table-success table-striped table-bordered">
                        <thead>
                        <tr>
                            <th class="show-costs-list__num" scope="col">#</th>
                            <th class="show-costs-list__date" scope="col">{{ __('cost/edit.text_date') }}</th>
                            <th class="show-costs-list__limit-per-day"
                                scope="col">{{ __('cost/edit.text_limit_per_day') }}</th>
                            <th class="show-costs-list__limit-per-day"
                                scope="col">{{ __('cost/edit.text_limit_per_left_day') }}</th>
                            <th scope="col">{{ __('cost/edit.text_costs') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cost_info->get('dates') as $date)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td class="show-costs-list__date">{{ $date['date'] }}</td>
                                <td class="show-costs-list__limit-per-day">{{ $cost_info->get('money_limit_per_day') }}</td>
                                <td class="show-costs-list__limit-per-day">{{ $date['money_limit_per_left_day'] ?? '' }}</td>
                                <td>
                                    <div class="accordion" id="accordion-costs">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse-costs-{{ $loop->iteration }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapse-costs">
                                                    <span>{{ __('cost/edit.text_edit_costs') }}</span>
                                                    <span>{{ __('cost/edit.text_hide_costs') }}</span>
                                                </button>
                                            </h2>
                                            <div id="collapse-costs-{{ $loop->iteration }}"
                                                 class="accordion-collapse collapse"
                                                 data-bs-parent="#accordion-costs">
                                                <div class="accordion-body add-costs">
                                                    <div class="d-flex flex-column gap-3 col-12 mb-3">
                                                        <button type="button" data-date="{{ $date['date'] }}"
                                                                class="btn btn-success costs__add-costs-btn col-3">
                                                            <i class="bi bi-plus-circle"></i>
                                                            <span class="ms-2">
                                                            {{ __('cost/create.text_add_costs_btn') }}
                                                        </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-danger">
                        {{ __('cost/edit.error_some_error_dates') }}
                    </div>
                @endif
            </div>
        </form>

        @include('partials.add_cost_prototype')
    </div>
@endsection
