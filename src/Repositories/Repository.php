<?php

namespace JbGlobal\Repositories;

use Illuminate\Pagination\Paginator;

abstract class Repository
{
    protected $model;

    public function todos(array $colunas = ['*'])
    {
        return $this->model->get($colunas);
    }

    public function buscar($id, array $colunas = ['*'])
    {
        return $this->model->find($id, $colunas);
    }

    public function buscarPor($coluna, $valor, $with=[])
    {
        return $this->model->with($with)->where($coluna, $valor)->first();
    }

    public function buscarExcluido($id, array $colunas = ['*'])
    {
        return $this->model->onlyTrashed()->find($id, $colunas);
    }

    public function paginar($pagina, $limite = 10)
    {
        Paginator::currentPageResolver(function () use ($pagina) {
            return $pagina;
        });
        return $this->model->paginate($limite);
    }

    public function criarArrayValido(array $dados)
    {
        return $this->model->fill($dados)->toArray();
    }

    public function criar(array $dados)
    {
        return $this->model->create($dados);
    }

    public function atualizar(array $dados, $id)
    {
        return $this->model->where('id', $id)->update($dados) ? true : false;
    }

    public function excluir($id)
    {
        return $this->model->destroy($id) ? true : false;
    }

}
