<?php

namespace App\Services\BrasilAPI\Entities;

use App\Services\BrasilAPI\Enum\CNPJSituacaoCadastral;

class CNPJ
{
    public string $cnpj;
    public string $razaoSocial;
    public CNPJSituacaoCadastral $descricaoSituacaoCadastral;

    public function __construct(array $data)
    {
        $this->cnpj = $data['cnpj'];
        $this->razaoSocial = $data['razao_social'];
        $this->descricaoSituacaoCadastral = CNPJSituacaoCadastral::from($data['descricao_situacao_cadastral']);
    }
}
