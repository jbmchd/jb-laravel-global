<?php

namespace JbGlobal\Services\Pessoas;

use JbGlobal\Repositories\Pessoas\UsuarioAdminRepository as Repository;

class UsuarioAdminService extends UsuariosPapeisService
{
    public function __construct(Repository $repositorio, PessoaService $pessoa_service)
    {
        parent::__construct($repositorio, $pessoa_service);
    }
}
