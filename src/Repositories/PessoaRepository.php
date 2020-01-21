<?php

namespace JbGlobal\Repositories;

use JbGlobal\Models\Pessoa;
use Illuminate\Support\Facades\DB;

class PessoaRepository extends Repository
{
    public function __construct(Pessoa $model)
    {
        $this->model = $model;
    }

    public function cadastrarComUsuario(array $pessoa_dados, array $usuario_dados)
    {
        DB::beginTransaction();
        $pessoa = $this->model->create($pessoa_dados);
        $pessoa->usuario()->create($usuario_dados);
        DB::commit();
        return $pessoa;
    }

    public function atualizarComUsuario(array $pessoa_dados, array $usuario_dados)
    {
        DB::beginTransaction();
        $pessoa = $this->model->with(['usuario'])->find($pessoa_dados['id']);
        $pessoa->update($pessoa_dados);

        $usuario = $pessoa->usuario()->first();
        $usuario = $usuario->update($usuario_dados);

        DB::commit();
        return $pessoa;
    }
}
