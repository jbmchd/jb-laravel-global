<?php

namespace JbGlobal\Repositories;

use JbGlobal\Models\Pessoa;

class PessoaAdminRepository extends PessoaRepository
{
    public function __construct(Pessoa $model)
    {
        $this->model = $model;
    }

    public function todos(array $colunas = ['*'])
    {
        return $this->model->admins()->get($colunas);
    }
}
