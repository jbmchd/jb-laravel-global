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

    public function buscar(array $colunas = ['*'])
    {
        return $this->repositorio->buscar($colunas);
    }

    public function buscarPor($coluna, $valor, $with=[])
    {
        return $this->repositorio->buscarPor($coluna, $valor, $with);
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
        return $this->repositorio->atualizar($dados, $id);
    }

    public function deletar($id)
    {
        return $this->repositorio->deletar($id);
    }

}
