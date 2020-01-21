<?php

namespace JbGlobal\Services;

use JbGlobal\Repositories\PessoaUsuarioRepository;

class PessoaUsuarioService extends PessoaService
{
    public function __construct(PessoaUsuarioRepository $repositorio)
    {
        parent::__construct($repositorio);
    }

    public function cadastrarComUsuario(array $dados)
    {
        $dados['papel'] = 'ADM';
        return parent::cadastrarComUsuario($dados);
    }
}
