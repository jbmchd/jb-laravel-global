<?php

namespace JbGlobal\Repositories;

use JbGlobal\Models\Log;

class LogRepository extends CrudRepository
{
    protected $model = Log::class;

    public function todos(array $colunas = ['*'])
    {
        return $this->model->with('usuario')->get($colunas);
    }
}
