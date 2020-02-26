<?php

namespace JbGlobal\Repositories;

use Illuminate\Pagination\Paginator;
use JbGlobal\Traits\{ TArray, TDiversos, TException, TLog, TValidation, TFile };

abstract class Repository
{
    use TArray, TDiversos, TException, TFile, TLog, TValidation;

    protected $model;

    public function buscar(array $colunas = ['*'])
    {
        return $this->model->get($colunas);
    }

    public function encontrar($id, array $colunas = ['*'])
    {
        return $this->model->find($id, $colunas);
    }

    public function encontrarPor($coluna, $valor, $with=[])
    {
        return $this->model->with($with)->where($coluna, $valor)->first();
    }

    public function encontrarExcluido($id, array $colunas = ['*'])
    {
        return $this->model->onlyTrashed()->find($id, $colunas);
    }

    // public function criarArrayValido(array $dados)
    // {
    //     return $this->model->fill($dados)->toArray();
    // }

    public function criar(array $dados)
    {
        unset($dados[$this->model->getKeyName()]);
        $dados = $this->criarArrayValido($dados);
        return $this->model->create($dados);
    }

    public function atualizar(array $dados, $id)
    {
        $pk_name = $this->model->getKeyName();
        $dados = $this->criarArrayValido($dados, $id);
        return $this->model->where($pk_name, $id)->update($dados) ? true : false;
    }

    public function deletar($id)
    {
        $model = $this->encontrar($id);
        if($model) $model->delete();
        return $model;
    }

    public function paginar($pagina, $limite = 10)
    {
        Paginator::currentPageResolver(function () use ($pagina) {
            return $pagina;
        });
        return $this->model->paginate($limite);
    }

    public function criarArrayValido(array $dados, $ignorar_pk=0)
    {
        $dados[$this->model->getKeyName()] = $ignorar_pk;
        $validacao = $this->validar($dados, $this->regras($ignorar_pk));
        if ($validacao['erro']) {
            return $validacao;
        }

        return $this->model->fill($dados)->toArray();
    }

    public function regras($ignorar_pk = 0)
    {
        return [];
    }

}
