<?php

namespace App\Rules\Cost;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidateAddCost implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail) : void
    { //TODO: add to check type of name and total
        if (!is_array($value)) {
            $fail(__('cost/create.error_cost_array'));
        }

        if (isset($value['name']) && !$value['name']) {
            $fail(__('cost/create.error_cost_name'));
        } else if (isset($value['total']) && !$value['total']) {
            $fail(__('cost/create.error_cost_total'));
        }

        $cost_names_length = count($value['name']);

        for ($name_index = 0; $name_index < $cost_names_length; $name_index++) {
            if (empty($value['name'][$name_index])) {
                $fail(__('cost/create.error_cost_some_name'));

                break;
            } else if (!isset($value['total'][$name_index]) || (empty($value['total'][$name_index]) && $value['total'][$name_index] != 0)) {
                $fail(__('cost/create.error_cost_some_total'));

                break;
            }
        }
    }
}
