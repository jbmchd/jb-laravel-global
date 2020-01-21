<?php

namespace JbGlobal\Repositories;

use JbGlobal\Models\Pessoa;

class PessoaUsuarioRepository extends PessoaRepository
{
    public function __construct(Pessoa $model)
    {
        $this->model = $model;
    }

    public function todos(array $colunas = ['*'])
    {
        return $this->model->users()->get($colunas);
    }
}
