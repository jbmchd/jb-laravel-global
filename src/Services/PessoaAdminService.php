<?php

namespace JbGlobal\Services;

use JbGlobal\Repositories\PessoaAdminRepository;

class PessoaAdminService extends PessoaService
{
    public function __construct(PessoaAdminRepository $repositorio, UsuarioService $usuario_servico)
    {
        parent::__construct($repositorio, $usuario_servico);
    }

    public function cadastrarComUsuario(array $dados)
    {
        $dados['papel'] = 'ADM';
        return parent::cadastrarComUsuario($dados);
    }
}
