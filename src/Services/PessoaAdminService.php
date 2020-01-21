<?php

namespace JbGlobal\Services;

use JbGlobal\Repositories\PessoaAdminRepository;

class PessoaAdminService extends PessoaService
{
    public function __construct(PessoaAdminRepository $repositorio)
    {
        parent::__construct($repositorio);
    }

    public function cadastrarComUsuario(array $dados)
    {
        $dados['papel'] = 'ADM';
        return parent::cadastrarComUsuario($dados);
    }
}
