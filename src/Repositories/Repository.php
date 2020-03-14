<?php

namespace JbGlobal\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use JbGlobal\Exceptions\RepositoryException;
use JbGlobal\Traits\{ TArray, TDiversos, TException, TLog, TValidation, TFile };

abstract class Repository
{
    use TArray, TDiversos, TException, TFile, TLog, TValidation;

    protected $model;

    public function __construct(\Illuminate\Database\Eloquent\Model $model)
    {
        $model->model_class = get_class($model);
        $this->model = $model;
    }

    // BUSCAS
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

    // CRUD
    public function criar(array $dados, array $with = null)
    {
        DB::beginTransaction();
        unset($dados[$this->model->getKeyName()]);
        $model = $this->model->create($dados);
        $model = $this->saveWith($model, $with) ?? $model;
        DB::commit();
        return $model;
    }

    public function atualizar(array $dados, $id, array $with = null)
    {
        DB::beginTransaction();
        $model = $this->encontrar($id);
        if(!$model) return $model;
        $model->model_class = $this->model->model_class;
        $model->fill($dados);
        $model->update();
        $model = $this->saveWith($model, $with) ?? $model;
        DB::commit();
        return $model;
    }

    // public function atualizar(array $dados, $id)
    // {
    //     $model = $this->encontrar($id);
    //     if($model){
    //         $dados = $this->criarArrayValido($dados, $id);
    //         $model->fill($dados);
    //         $model->save();
    //     }
    //     return $model ?? null;
    // }

    public function deletar($id, array $with = null)
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
    // public function deletar($id)
    // {
    //     $model = $this->encontrar($id);
    //     if($model) $model->delete();
    //     return $model ?? null;
    // }

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

    public function saveWith(Model $model, array $with = null)
    {
        if($with){
            $hasmanys = [];
            foreach ($with as $key => $cada) {
                $hasmany = $cada['hasmany'];
                $model->{$hasmany}()->createMany($cada['dados']);
                array_push($hasmanys, $hasmany);
            }
            return $this->encontrarPor('id',$model->id, $hasmanys);
        }
        return false;
    }

    // OUTROS
    public function paginar($pagina, $limite = 10)
    {
        Paginator::currentPageResolver(function () use ($pagina) {
            return $pagina;
        });
        return $this->model->paginate($limite);
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

    // public function regras($ignorar_pk = 0, $dados)
    // {
    //     return $ignorar_pk ? ["id" => "primary_key|unique:$this->model_class,id,$ignorar_pk"] : [];
    // }

}
