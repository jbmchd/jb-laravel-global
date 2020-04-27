<?php

namespace JbGlobal\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use JbGlobal\Exceptions\RepositoryException;
use JbGlobal\Traits\{ TArray, TDiversos, TException, TLog, TValidation, TFile, TSessao };

abstract class Repository
{
    use TArray, TDiversos, TException, TFile, TLog, TValidation, TSessao;

    protected $model;
    protected $view;

    public function __construct(Model $model, Model $view=null)
    {
        $model->model_class = get_class($model);
        $this->model = $model;
        $this->view = $view ?? $model;
    }

    // BUSCAS
    public function ativos()
    {
        return $this->view->ativos()->get();
    }

    public function buscar(array $colunas = ['*'], array $with=[])
    {
        return $this->view->with($with)->get($colunas);
    }

    public function buscarPor($coluna, $valor, array $colunas = ['*'], array $with=[])
    {
        return $this->view->where($coluna, $valor)->with($with)->get($colunas);
    }

    public function encontrar($id, array $colunas = ['*'])
    {
        return $this->view->find($id, $colunas);
    }

    public function encontrarPor($coluna, $valor, $with=[])
    {
        return $this->view->with($with)->where($coluna, $valor)->first();
    }

    public function encontrarExcluido($id, array $colunas = ['*'])
    {
        return $this->view->onlyTrashed()->find($id, $colunas);
    }

    // CRUD
    public function criar(array $dados, array $with = [])
    {
        DB::beginTransaction();
        unset($dados[$this->model->getKeyName()]);
        $model = $this->model->create($dados);
        $model = $with ? $this->saveWith($model, $with) : $model;
        DB::commit();
        return $model;
    }

    public function atualizar(array $dados, $id, array $with = [])
    {
        DB::beginTransaction();
        $model = $this->model->find($id);
        if(!$model) return $model;
        $dados[$model->getKeyName()] = $id;
        $model->model_class = $this->model->model_class;
        $model->fill($dados);
        $model->update();
        $model = $with ? $this->saveWith($model, $with) : $model;
        DB::commit();
        return $model;
    }

    public function deletar($id, array $with = [])
    {
        DB::beginTransaction();
        $model = $this->encontrarPor('id',$id,$with);
        if($model) {
            if($with){
                foreach ($with as $key => $relacionamento) {
                    $model->{$relacionamento}()->delete();
                }
            }
            $model->delete();
        }
        DB::commit();
        return $model;
    }

    public function criarNM(array $dados_n, array $ids_m, string $tabela_m)
    {
        DB::beginTransaction();
        $result = $this->criar($dados_n);
        throw_if(!$result, new RepositoryException("Problema ao inserir os dados na tabela {$this->model->getTable()}"));
        $result->$tabela_m()->attach($ids_m);
        DB::commit();
        return $result;
    }

    public function atualizarNM(array $dados_n, $id_n, array $ids_m, string $tabela_m)
    {
        DB::beginTransaction();
        $result = $this->atualizar($dados_n, $id_n);
        throw_if(!$result, new RepositoryException("Problema ao atualizar os dados na tabela {$this->model->getTable()}"));
        $result->$tabela_m()->sync($ids_m);
        DB::commit();
        return $result;
    }

    public function deletarNM($id, $tabela_m)
    {
        DB::beginTransaction();
        $result = $this->deletar($id);
        throw_if(!$result, new RepositoryException("Problema ao deletar os dados na tabela {$this->model->getTable()}"));
        $result->$tabela_m()->detach();
        DB::commit();

        return $result;
    }

    public function saveWith(Model $model, array $with)
    {
        $hasmanys = [];
        foreach ($with as $key => $cada) {
            $hasmany = $cada['hasmany'];
            $model->{$hasmany}()->createMany($cada['dados']);
            array_push($hasmanys, $hasmany);
        }
        return $this->encontrarPor('id',$model->id, $hasmanys);
    }

    // OUTROS
    public function paginar($pagina, $limite = 10)
    {
        Paginator::currentPageResolver(function () use ($pagina) {
            return $pagina;
        });
        return $this->view->paginate($limite);
    }

    public function criarModelValido(array $dados, $ignorar_pk=0)
    {
        $dados = $this->criarArrayValido($dados, $ignorar_pk);
        return $this->model->fill($dados);
    }

    public function criarArrayValido(array $dados, $ignorar_pk=0)
    {
        $dados[$this->model->getKeyName()] = $ignorar_pk;
        $validacao = $this->validar($dados, $this->regras($ignorar_pk, $dados));
        if ($validacao['erro']) {
            return $validacao;
        }
        return $dados;
    }
}
