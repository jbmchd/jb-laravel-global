<?php

namespace JbGlobal\Repositories;

use JbGlobal\Models\Usuario;

class UsuarioRepository extends Repository
{
    public function __construct(Usuario $model)
    {
        $this->model = $model;
    }

    public function alterarSenha($usuario_id, $senha_hash)
    {
        $this->model->find($usuario_id)->update(['senha' => $senha_hash]);
        return true;
    }

    public function criarArrayValido(array $dados)
    {
        $Usuario = $this->model->fill($dados);
        $usuario = $Usuario->toArray();
        $usuario['senha'] = $Usuario->senha;
        return $usuario;
    }
}
