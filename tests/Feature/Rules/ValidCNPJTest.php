<?php

namespace Tests\Feature\Rules;

use App\Rules\ValidCNPJ;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ValidCNPJTest extends TestCase
{
    /** @test */
    public function it_should_check_if_the_cnpj_is_valid_and_active(): void
    {
        Http::fake([
            'https://brasilapi.com.br/api/cnpj/v1/06990590000123' => Http::response(
                [
                    'cnpj' => '06.990.590/0001-23',
                    'razao_social' => 'Empresa test',
                    'descricao_situacao_cadastral' => 'ATIVA'
                ]
            , 200)
        ]);
        // CNPJ GOOGLE: 06990590000123
        $validator = Validator::make(['cnpj' => '06990590000123'], ['cnpj' => new ValidCNPJ()]);
        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function return_false_if_cnpj_is_not_found_or_not_active(): void
    {
        Http::fake([
            'https://brasilapi.com.br/api/cnpj/v1/06990590000133' => Http::response(
                [], 404
            ),
            'https://brasilapi.com.br/api/cnpj/v1/06990590000133' => Http::response(
                [
                    'cnpj' => '06.990.590/0001-33',
                    'razao_social' => 'Empresa test',
                    'descricao_situacao_cadastral' => 'INATIVA'
                ], 200
            ),
        ]);

        $validator = Validator::make(['cnpj' => '06990590000133'], ['cnpj' => new ValidCNPJ()]);
        $this->assertTrue($validator->fails());
    }
}
