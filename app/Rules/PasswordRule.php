<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $min = 8;
        $max = 40;
        if (! is_string($value))
        {
            $fail("O :attribute deve ser string.");
            return;
        }
        if (strlen($value) < $min)
        {
            $fail("O :attribute deve ter no mínimo $min caracteres.");
        }
        if (strlen($value) > $max)
        {
            $fail("O :attribute deve ter no mínimo $max caracteres.");
        }
    }
}
