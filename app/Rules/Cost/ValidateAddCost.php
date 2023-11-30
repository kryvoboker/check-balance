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
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail) : void
    {
        $error_not_array_message = $this->isArrayValue($value);

        foreach ($value as $date_info) {
            $error_empty_name_message = $this->isEmptyName(($date_info['name'] ?? null));
            $error_empty_total_message = $this->isEmptyTotal(($date_info['total'] ?? null));

            if ($error_not_array_message || $error_empty_total_message || $error_empty_total_message) {
                $fail(($error_not_array_message ?: $error_empty_name_message ?: $error_empty_total_message));

                return;
            }
        }

        $this->checkOtherErrors($value, $fail);
    }

    /**
     * @param array|null $name
     * @return string
     */
    private function isEmptyName(?array $name) : string
    {
        return (empty($name) ? __('cost/create.error_cost_name') : '');
    }

    /**
     * @param array|null $total
     * @return string
     */
    private function isEmptyTotal(?array $total) : string
    {
        return (empty($total) ? __('cost/create.error_cost_total') : '');
    }

    /**
     * @param mixed $value
     * @return string
     */
    private function isArrayValue(mixed $value) : string
    {
        return (!is_array($value) ? __('cost/create.error_cost') : '');
    }

    /**
     * @param array $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    private function checkOtherErrors(array $value, Closure $fail) : void
    {
        foreach ($value as $date_info) {
            $cost_names_length = count($date_info['name']);

            for ($name_index = 0; $name_index < $cost_names_length; $name_index++) {
                if (empty($date_info['name'][$name_index])) {
                    $fail(__('cost/create.error_cost_some_name'));

                    break;
                } else if (!isset($date_info['total'][$name_index]) || (empty($date_info['total'][$name_index]) && $date_info['total'][$name_index] != 0)) {
                    $fail(__('cost/create.error_cost_some_total'));

                    break;
                } else if (!is_numeric($date_info['total'][$name_index])) {
                    $fail(__('cost/create.error_cost_some_numeric'));

                    break;
                }
            }
        }
    }
}
