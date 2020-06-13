<?php

namespace JbGlobal\Services;

use JbGlobal\Repositories\Repository;

abstract class CrudService extends Service
{
    protected $repositorio;

    public function __construct(Repository $repositorio)
    {
        $this->repositorio = $repositorio;
    }

    public function ativos()
    {
        return $this->repositorio->ativos();
    }

    public function buscar(array $colunas = ['*'], $with = [], array $scopes = [])
    {
        $result = $this->repositorio->buscar($colunas, $with, $scopes);
        return $this->alterarRetornoBusca($result);
    }

    public function buscarPor($coluna, $valor, $with=[], array $scopes=[])
    {
        $result = $this->repositorio->buscarPor($coluna, $valor, $with, $scopes);
        return $this->alterarRetornoBusca($result);
    }

    public function encontrar($id, array $colunas = ['*'], array $scopes=[])
    {
        $result = $this->repositorio->encontrar($id, $colunas, $scopes);
        return $this->alterarRetornoBusca($result);
    }

    public function encontrarPor($coluna, $valor, $with=[], array $scopes=[])
    {
        $result = $this->repositorio->encontrarPor($coluna, $valor, $with, $scopes);
        return $this->alterarRetornoBusca($result);
    }

    public function criar(array $dados)
    {
        $dados = $this->alterarDadosAntesDoCrud($dados);
        return $this->repositorio->criar($dados);
    }

    public function atualizar(array $dados, $id)
    {
        $dados = $this->alterarDadosAntesDoCrud($dados);
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

        $dados = $this->alterarDadosAntesDoCrud($dados);
        return $this->repositorio->criarNM($dados, $ids_tabela_m, $nome_tabela_m);
    }

    public function atualizarNM(array $dados, $id, $nome_array_ids_tabela_m, $nome_tabela_m)
    {
        $ids_tabela_m = [];
        if(isset($dados[$nome_array_ids_tabela_m])){
            $ids_tabela_m = $dados[$nome_array_ids_tabela_m];
            unset($dados[$nome_array_ids_tabela_m]);
        }

        $dados = $this->alterarDadosAntesDoCrud($dados);
        return $this->repositorio->atualizarNM($dados, $id, $ids_tabela_m, $nome_tabela_m);
    }

    public function deletarNM($id, $nome_tabela_m)
    {
        return $this->repositorio->deletarNM($id, $nome_tabela_m);
    }

    public function alterarDadosAntesDoCrud(array $dados)
    {
        return $dados;
    }

    public function alterarRetornoBusca($dados){
        return $dados;
    }

}
