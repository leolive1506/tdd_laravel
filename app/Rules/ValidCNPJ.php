<?php

namespace App\Rules;

use Closure;
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
        $response = Http::get("https://brasilapi.com.br/api/cnpj/v1/{$value}");
        $status = $response->status();

        if ($status !== 200) {
            $fail('The :attribute dont exists');
            return;
        }

        $active = $response->json()['descricao_situacao_cadastral'] === 'ATIVA';

        if (!$active) {
            $fail('The :attribute dont exists');
            return;
        }
    }
}
