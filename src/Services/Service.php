<?php

namespace JbGlobal\Services;

use JbGlobal\Repositories\Repository;
use JbGlobal\Traits\{ TArray, TDiversos, TException, TLog, TValidation, TFile };

abstract class Service
{
    use TArray, TDiversos, TException, TFile, TLog, TValidation;

    protected $repositorio;

    public function __construct(Repository $repositorio)
    {
        $this->repositorio = $repositorio;
    }

    public function buscar(array $colunas = ['*'])
    {
        return $this->repositorio->buscar($colunas);
    }

    public function encontrar($id, array $colunas = ['*'])
    {
        return $this->repositorio->encontrar($id, $colunas);
    }

    public function encontrarPor($coluna, $valor, $with=[])
    {
        return $this->repositorio->encontrarPor($coluna, $valor, $with);
    }

    public function criar(array $dados)
    {
        return $this->repositorio->criar($dados);
    }

    public function atualizar(array $dados, $id)
    {
        $this->repositorio->atualizar($dados, $id);
        return $this->encontrar($id);
    }

    public function deletar($id)
    {
        return $this->repositorio->deletar($id);
    }

}
