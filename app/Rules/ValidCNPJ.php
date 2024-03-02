<?php

namespace App\Rules;

use App\Services\BrasilAPI\BrasilAPI;
use App\Services\BrasilAPI\Exceptions\CNPJNotFound;
use Closure;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class ValidCNPJ implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            (new BrasilAPI())->cnpj($value);
        } catch (Exception $e) {
            $fail('The :attribute dont exists');
        }
    }
}
