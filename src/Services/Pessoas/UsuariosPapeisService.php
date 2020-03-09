<?php

namespace JbGlobal\Services\Pessoas;

use JbGlobal\Repositories\Repository;

class UsuariosPapeisService extends UsuarioService
{
    public function __construct(Repository $repositorio, PessoaService $pessoa_service)
    {
        parent::__construct($repositorio, $pessoa_service);
    }
}
