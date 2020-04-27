<?php

namespace JbGlobal\Models;

use Illuminate\Database\Eloquent\Model as LaravelModel;
use JbGlobal\Traits\{ TArray, TDiversos, TException, TLog, TValidation, TFile, TSessao };

abstract class Model extends LaravelModel
{
    use TArray, TDiversos, TException, TFile, TLog, TValidation, TSessao;

    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'alterado_em';
    const DELETED_AT = 'deletado_em';

    protected $hidden = ['pivot'];
    protected $dates = ['deletado_em'];

    protected $casts = [
        'id' => 'integer',
        'ativo' => 'boolean',
    ];

    public $model_class;

    protected static function aplicarRegras(LaravelModel $model){
        $model->makeVisible($model->getHidden());
        $dados = $model->toArray();
        $ignorar_pk = $model->{$model->getKeyName()} ?? 0;
        $regras = $model->regras($ignorar_pk, $dados);
        self::validar($dados, $regras);
    }

    protected static function boot() {
        parent::boot();

        self::saving(function($model) {
            self::aplicarRegras($model);
        });
    }

    public static function scopeAtivos($query, $coluna_nome='ativo')
    {
        return $query->where($coluna_nome, 1);
    }

    public static function getTableName()
    {
        return (new self())->getTable();
    }

    public function regras($ignorar_pk = 0, $dados = [])
    {
        return $ignorar_pk ? ["id" => "primary_key|unique:$this->model_class,id,$ignorar_pk"] : [];
    }
}
