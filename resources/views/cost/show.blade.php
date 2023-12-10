@extends('layouts.main')

@section('title', __(
            'cost/show.heading_title',
            ['start' => $cost_info->get('start_date'), 'end' => $cost_info->get('end_date')]
))

@section('content')
    <div class="container">
        <form class="d-none" method="POST"
              action="{{ route('costs.destroy', ['cost' => $cost_id]) }}" id="delete-cost-form">
            @csrf
            @method('DELETE')
        </form>

        <h1 class="mb-5">
            {{ __(
                'cost/show.heading_title',
                ['start' => $cost_info->get('start_date'), 'end' => $cost_info->get('end_date')]
            ) }}
        </h1>

        <div class="show-costs-list">
            @if($cost_info->has('dates'))
                <table class="table table-success table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="show-costs-list__num" scope="col">#</th>
                        <th class="show-costs-list__date" scope="col">{{ __('cost/show.text_date') }}</th>
                        <th class="show-costs-list__limit-per-day"
                            scope="col">{{ __('cost/show.text_limit_per_day') }}</th>
                        <th class="show-costs-list__limit-per-day"
                            scope="col">{{ __('cost/show.text_limit_per_left_day') }}</th>
                        <th scope="col">{{ __('cost/show.text_costs') }}</th>
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
                                                <span>{{ __('cost/show.text_show_costs') }}</span>
                                                <span>{{ __('cost/show.text_hide_costs') }}</span>
                                            </button>
                                        </h2>
                                        <div id="collapse-costs-{{ $loop->iteration }}"
                                             class="accordion-collapse collapse"
                                             data-bs-parent="#accordion-costs">
                                            <div class="accordion-body">
                                                @if(isset($date['costs']) and $date['costs'])
                                                    @foreach ($date['costs'] as $cost)
                                                        <div class="row mb-3">
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label"
                                                                       for="cost-name-{{ $loop->iteration }}">
                                                                    {{ __('cost/show.text_cost_name') }}
                                                                </label>

                                                                <div class="col-sm-3">
                                                                    <input class="form-control" type="text"
                                                                           value="{{ $cost['cost_name'] }}"
                                                                           id="cost-name-{{ $loop->iteration }}" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label"
                                                                       for="cost-total-{{ $loop->iteration }}">
                                                                    {{ __('cost/show.text_cost_total') }}
                                                                </label>

                                                                <div class="col-sm-3">
                                                                    <input class="form-control" type="number"
                                                                           value="{{ $cost['cost_total'] }}"
                                                                           id="cost-total-{{ $loop->iteration }}" readonly>
                                                                </div>
                                                            </div>

                                                            <hr/>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p>{{ __('cost/show.text_empty_cost') }}</p>
                                                @endif
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
                    {{ __('cost/show.error_some_error_dates') }}
                </div>
            @endif
        </div>
    </div>
@endsection
