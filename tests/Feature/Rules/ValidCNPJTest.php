<?php

namespace Tests\Feature\Rules;

use App\Rules\ValidCNPJ;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ValidCNPJTest extends TestCase
{
    /** @test */
    public function it_should_check_if_the_cnpj_is_valid_and_active(): void
    {
        // CNPJ GOOGLE: 06990590000123
        $validator = Validator::make(['cnpj' => '06990590000123'], ['cnpj' => new ValidCNPJ()]);
        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function return_false_if_cnpj_is_not_found(): void
    {
        $validator = Validator::make(['cnpj' => '06990590000133'], ['cnpj' => new ValidCNPJ()]);
        $this->assertTrue($validator->fails());
    }
}
