<?php

namespace JbGlobal\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use JbGlobal\Exceptions\RepositoryException;
use JbGlobal\Traits\{ TArray, TException, TLog, TValidation, TFile };

abstract class CrudRepository extends Repository
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

    public function atualizar(array $dados, $id, array $with = [], bool $sincronizar = false)
    {
        DB::beginTransaction();
        $model = $this->model->find($id);
        if(!$model) return $model;
        $dados[$model->getKeyName()] = $id;
        $model->fill($dados);
        $model->update();
        $model = $with ? $this->saveWith($model, $with, $sincronizar) : $model;
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

    public function saveWith(Model $model, array $with, bool $sincronizar = false)
    {
        $all_has = [];
        foreach ($with as $key => $cada_with) {
            $has_name = $cada_with['has'];
            $dados = $cada_with['dados'];
            array_push($all_has, $has_name);

            $this->saveCadaWith($model, $has_name, $dados, $sincronizar);
        }

        return $this->encontrarPor('id',$model->id, $all_has);
    }

    public function saveCadaWith(Model $parent_model, $has_name, array $dados, bool $sincronizar = false){
        $no_banco = $parent_model->{$has_name}()->get()->modelKeys();

        $models_has = array_map(function($cada_dados) use ($parent_model, $has_name) {
            $id = $cada_dados['id'] ?? null;
            $model_has = $id ? $parent_model->{$has_name}()->find($id) : $parent_model->{$has_name}()->getRelated();
            return $model_has->fill($cada_dados);
        }, $dados);

        $result_save = $parent_model->{$has_name}()->saveMany($models_has);


        if($sincronizar){
            $result_save_ids = array_map(function($cada){return $cada->id ?? null;}, $result_save);
            $manter_no_banco = array_filter(array_map(function($cada){
                return $cada['id'] ?? null ? (int) $cada['id'] : null;
            }, $dados));

            array_push($manter_no_banco, ...$result_save_ids);
            $apagar_ids = array_diff($no_banco, $manter_no_banco);
            $class = get_class($parent_model->{$has_name}()->getRelated());
            $class::destroy($apagar_ids);
        }
        return $result_save;
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
