<?php

namespace JbGlobal\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use JbGlobal\Exceptions\RepositoryException;
use JbGlobal\Traits\{ TArray, TException, TLog, TValidation, TFile };

abstract class Repository
{
    use TRepository, TArray, TException, TFile, TLog, TValidation;

    const SINCRONIZAR = true;

    protected $model;
    protected $view;

    public function __construct(Model $model, Model $view=null)
    {
        $this->model = $model;
        $this->view = $view ?? $model;
    }

    // BUSCAS
    public function ativos()
    {
        return $this->view->ativos()->get();
    }

    public function buscar(array $colunas = ['*'], array $with=[], array $scopes=[])
    {
        $query = $this->view->with($with);
        $query = self::queryAdicionarScopes($query, $scopes);
        return $query->get($colunas);
    }

    public function buscarPor($coluna, $valor, array $colunas = ['*'], array $with=[], array $scopes=[])
    {
        $query = $this->view->where($coluna, $valor)->with($with);
        $query = self::queryAdicionarScopes($query, $scopes);
        return $query->get($colunas);
    }

    public function encontrar($id, array $colunas = ['*'], array $with=[], array $scopes=[])
    {
        $query = $this->view->with($with);
        $query = self::queryAdicionarScopes($query, $scopes);
        return $query->find($id, $colunas);
    }

    public function encontrarPor($coluna, $valor, $with=[], array $scopes=[])
    {
        $query = $this->view->with($with)->where($coluna, $valor);
        $query = self::queryAdicionarScopes($query, $scopes);
        return $query->first();
    }

    public function encontrarExcluido($id, array $colunas = ['*'], array $scopes=[])
    {
        $query = $this->view->onlyTrashed();
        $query = self::queryAdicionarScopes($query, $scopes);
        return $query->find($id, $colunas);
    }

    // OUTROS
    public function paginar($pagina, $limite = 10)
    {
        Paginator::currentPageResolver(function () use ($pagina) {
            return $pagina;
        });
        return $this->view->paginate($limite);
    }

}
