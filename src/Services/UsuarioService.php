<?php

namespace JbGlobal\Services;

use JbGlobal\Repositories\UsuarioRepository as Repository;
use JbGlobal\Services\CrudService as Service;

class UsuarioService extends Service
{
    protected $pessoa_service;

    public function __construct(Repository $repositorio)
    {
        parent::__construct($repositorio);
    }

    // public function encontrarPessoaPor($coluna, $valor, $with=[])
    // {
    //     return $this->pessoa_service->encontrarPor($coluna, $valor, $with);
    // }

    // public function criarComPessoa(array $dados)
    // {
    //     unset($dados['id']);
    //     return $this->repositorio->criarComPessoa($dados);
    // }

    // public function preparar(array $usuario)
    // {
    //     $usuario['senha'] = $this->repositorio->criarSenha($usuario['senha']);
    //     return $usuario;
    // }
}
