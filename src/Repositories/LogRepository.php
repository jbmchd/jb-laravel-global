<?php

namespace JbGlobal\Repositories;

use JbGlobal\Models\Log;

class LogRepository extends Repository
{
    public function __construct(Log $model)
    {
        $this->model = $model;
    }

    public function todos(array $colunas = ['*'])
    {
        return $this->model->with('usuario')->get($colunas);
    }
}
