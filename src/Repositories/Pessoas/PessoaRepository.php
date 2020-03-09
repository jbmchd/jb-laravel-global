<?php

namespace JbGlobal\Repositories\Pessoas;

use Illuminate\Support\Facades\DB;
use JbGlobal\Models\Pessoa;
use JbGlobal\Repositories\Repository;

class PessoaRepository extends Repository
{
    public function __construct(Pessoa $model)
    {
        $this->model = $model;
    }

    public function regras($ignorar_pk = 0, $dados = [])
    {
        $regras = [
            "nome" => "nullable|string|max:255",
            "email" => "required|email|unique:pessoas,email,$ignorar_pk",
            "ativo" => "required|boolean",
        ];

        return array_merge($regras, parent::regras($ignorar_pk, $dados));
    }
}
