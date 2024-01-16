<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ForbiddenWordsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $forbiddenWords = ['fuck'];

        foreach ($forbiddenWords as $word) {
            if (stripos($value, $word) !== false) {
                $fail('The :attribute contains bad words');
            }
        }
    }
}
