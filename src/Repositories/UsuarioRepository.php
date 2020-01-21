<?php

namespace JbGlobal\Repositories;

use JbGlobal\Models\Usuario;
use JbGlobal\Models\Pessoa;

class UsuarioRepository extends Repository
{
    public function __construct(Usuario $model)
    {
        $this->model = $model;
    }

    public function alterarSenha(Pessoa $Pessoa, $senha_hash)
    {
        $this->model->find($Pessoa->usuario->id)->update(['senha' => $senha_hash]);
        return $Pessoa;
    }

    public function criarArrayValido(array $dados)
    {
        $Usuario = $this->model->fill($dados);
        $usuario = $Usuario->toArray();
        $usuario['senha'] = $Usuario->senha;
        return $usuario;
    }
}
