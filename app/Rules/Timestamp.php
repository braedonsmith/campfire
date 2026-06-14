<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Timestamp implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!\is_string($value)) {
            $fail("$attribute is not a string.");
        }

        if (!preg_match('/^(-?(?:[1-9][0-9]*)?[0-9]{4}-(?:1[0-2]|0[1-9])-(?:3[01]|[12][0-9]|0[1-9])($|T(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9](?:\.[0-9]+)?(Z|[+-][01][0-9]:?[0-5][0-9])?))$/', $value)) {
            $fail("$attribute is not an ISO 8601 timestamp.");
        }
    }
}
