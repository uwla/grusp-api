<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\ValidationRule;

class USPEmailRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^[a-zA-Z0-9_+-\.]+@([a-z0-9][a-z0-9_-]*\.)*usp\.br$/';
        if (! Str::isMatch($pattern, $value))
        {
            $fail('O :attribute deve ser um email USP válido.');
        }
    }
}
