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

        <div class="edit-costs-list">
            @if($cost_info->has('dates'))
                <table class="table table-success table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="show-costs-list__num" scope="col">#</th>
                        <th class="show-costs-list__date" scope="col">{{ __('cost/edit.text_date') }}</th>
                        <th class="show-costs-list__limit-per-day" scope="col">{{ __('cost/edit.text_limit_per_day') }}</th>
                        <th class="show-costs-list__limit-per-day" scope="col">{{ __('cost/edit.text_limit_per_left_day') }}</th>
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
                                        <div id="collapse-costs-{{ $loop->iteration }}" class="accordion-collapse collapse"
                                             data-bs-parent="#accordion-costs">
                                            <div class="accordion-body">
                                                <p>Some costs</p>
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
    </div>
@endsection
