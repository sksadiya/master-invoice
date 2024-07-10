<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumber implements ValidationRule
{
    protected $regionCode;

    public function __construct($regionCode)
    {
        $this->regionCode = $regionCode;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->regionCode == '91') { // India
            if (!preg_match('/^[0-9]{10}$/', $value)) {
                $fail('The :attribute must be exactly 10 digits for the selected region code.');
            }
        }
    }
}
