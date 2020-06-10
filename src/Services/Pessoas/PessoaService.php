<?php

namespace JbGlobal\Services\Pessoas;

use JbGlobal\Repositories\Pessoas\PessoaRepository as Repository;
use JbGlobal\Services\CrudService as Service;

class PessoaService extends Service
{
    protected $usuario_servico;

    public function __construct(Repository $repositorio)
    {
        parent::__construct($repositorio);
    }

}
