<?php

namespace JbGlobal\Models;

use Illuminate\Database\Eloquent\Model as LaravelModel;
use JbGlobal\Traits\{ TArray, TException, TLog, TValidation, TFile };

abstract class Model extends LaravelModel
{
    use TArray, TException, TFile, TLog, TValidation;

    protected $hidden = ['pivot'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'id' => 'integer',
        'ativo' => 'boolean',
    ];

    public $model_class;

    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->model_class = get_class($this);
    }

    protected static function boot() {
        parent::boot();

        self::saving(function($model) {
            self::aplicarRegras($model);
        });
    }

    protected static function aplicarRegras(LaravelModel $model){
        $campos_ocultos = $model->getHidden();

        $model->makeVisible($campos_ocultos);
        $ignorar_pk = $model->{$model->getKeyName()} ?? 0;

        $dados = $model->toArray();
        $regras = $model->regras($ignorar_pk, $dados);
        $dados_complementares = $model->dadosComplementaresParaValidacao($dados);

        self::validar(array_merge($dados, $dados_complementares), $regras);

        $model->makeHidden($campos_ocultos);
    }

    public static function scopeAtivos($query, $coluna_nome='ativo')
    {
        return $query->where($coluna_nome, 1);
    }

    public static function getTableName()
    {
        return (new self())->getTable();
    }

    // public function regras($ignorar_pk = 0, $dados = [])
    // {
    //     return $ignorar_pk ? ["id" => "primary_key|unique:$this->model_class,id,$ignorar_pk"] : [];
    // }

    // public function dadosComplementaresParaValidacao(array $dados)
    // {
    //     return [];
    // }
}
