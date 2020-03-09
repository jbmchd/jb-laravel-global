<?php

namespace JbGlobal\Repositories;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use JbGlobal\Traits\{ TArray, TDiversos, TException, TLog, TValidation, TFile };

abstract class Repository
{
    use TArray, TDiversos, TException, TFile, TLog, TValidation;

    protected $model;
    protected $model_class;

    public function __construct(\Illuminate\Database\Eloquent\Model $model)
    {
        $this->model = $model;
        $this->model_class = get_class($model);
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
    public function criar(array $dados)
    {
        unset($dados[$this->model->getKeyName()]);
        $model = $this->criarModelValido($dados);
        $model->save();
        return $model;
    }

    public function atualizar(array $dados, $id)
    {
        $model = $this->encontrar($id);
        if($model){
            $dados = $this->criarArrayValido($dados, $id);
            $model->fill($dados);
            $model->save();
        }
        return $model ?? false;
    }

    public function deletar($id)
    {
        $model = $this->encontrar($id);
        if($model) $model->delete();
        return $model;
    }

    public function criarNM(array $dados_n, array $ids_m, string $tabela_m)
    {
        DB::beginTransaction();
        $result = $this->criar($dados_n);
        $result->$tabela_m()->attach($ids_m);
        DB::commit();

        return $result;
    }

    public function atualizarNM(array $dados_n, $id_n, array $ids_m, string $tabela_m)
    {
        DB::beginTransaction();
        $result = $this->atualizar($dados_n, $id_n);
        $result->$tabela_m()->sync($ids_m);
        DB::commit();
        return $result;
    }

    public function deletarNM($id, $tabela_m)
    {
        DB::beginTransaction();
        $result = $this->deletar($id);
        $result->$tabela_m()->detach();
        DB::commit();

        return $result;
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

    public function regras($ignorar_pk = 0, $dados)
    {
        return $ignorar_pk ? ["id" => "primary_key|unique:$this->model_class,id,$ignorar_pk"] : [];
    }

}
