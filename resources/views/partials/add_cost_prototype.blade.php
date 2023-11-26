<div class="d-none row mb-3 add-costs-prototype">
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="cost-name">
            {{ __('cost/create.text_cost_name') }}
        </label>

        <div class="col-sm-3">
            <input class="form-control" type="text" name="cost[name][]" id="cost-name" required>

            <div class="invalid-feedback">
                {{ __('cost/create.error_cost_name') }}
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="cost-total">
            {{ __('cost/create.text_cost_total') }}
        </label>

        <div class="col-sm-3">
            <input class="form-control" type="number" name="cost[total][]" id="cost-total" required>

            <div class="invalid-feedback">
                {{ __('cost/create.error_cost_total') }}
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="cost-date">
            {{ __('cost/create.text_cost_date') }}
        </label>

        <div class="col-sm-3">
            <input class="form-control" type="date" name="cost[date][]" id="cost-date" required>

            <div class="invalid-feedback">
                {{ __('cost/create.error_cost_date') }}
            </div>
        </div>
    </div>

    <hr/>
</div>
