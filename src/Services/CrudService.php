<?php

namespace JbGlobal\Services;

use JbGlobal\Repositories\Repository;

abstract class CrudService extends Service
{
    protected $repositorio = Repository::class;

    public function criar(array $dados)
    {
        return $this->repositorio->criar($dados);
    }

    public function atualizar(array $dados, $id)
    {
        return $this->repositorio->atualizar($dados, $id);
    }

    public function deletar($id)
    {
        return $this->repositorio->deletar($id);
    }

    public function criarNM(array $dados, $nome_array_ids_tabela_m, $nome_tabela_m)
    {
        $ids_tabela_m = [];
        if(isset($dados[$nome_array_ids_tabela_m])){
            $ids_tabela_m = $dados[$nome_array_ids_tabela_m];
            unset($dados[$nome_array_ids_tabela_m]);
        }
        return $this->repositorio->criarNM($dados, $ids_tabela_m, $nome_tabela_m);
    }

    public function atualizarNM(array $dados, $id, $nome_array_ids_tabela_m, $nome_tabela_m)
    {
        $ids_tabela_m = null;
        if(isset($dados[$nome_array_ids_tabela_m])){
            $ids_tabela_m = $dados[$nome_array_ids_tabela_m];
            unset($dados[$nome_array_ids_tabela_m]);
        }
        return $this->repositorio->atualizarNM($dados, $id, $ids_tabela_m, $nome_tabela_m);
    }

    public function deletarNM($id, $nome_tabela_m)
    {
        return $this->repositorio->deletarNM($id, $nome_tabela_m);
    }


}
