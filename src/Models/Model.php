<?php

namespace JbGlobal\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use JbGlobal\Exceptions\ModelException;
use JbGlobal\Traits\{ TArray, TDiversos, TException, TLog, TValidation, TFile };

abstract class Model extends BaseModel
{
    use TArray, TDiversos, TException, TFile, TLog, TValidation;

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

    protected static function aplicarRegras(BaseModel $model){
        // dd('aplicar regras');
        $dados = $model->toArray();
        $ignorar_pk = $model->{$model->getKeyName()} ?? 0;
        $regras = $model->regras($ignorar_pk, $dados);
        self::validar($dados, $regras);
        // dd($dados, $regras);
    }

    public static function boot() {
        parent::boot();

        self::saving(function($model) {
            self::aplicarRegras($model);
        });
        // self::retrieved(function($model) {
        //     dd($model);
        //     self::aplicarRegras($model);
        // });
        // self::creating(function($model) {
        //     // dd('creating');
        //     self::aplicarRegras($model);
        // });
        // self::created(function($model) {
        //     dd('created');
        //     self::aplicarRegras($model);
        // });
        // self::updating(function($model) {
        //     dd('updating');
        //     self::aplicarRegras($model);
        // });
        // self::updated(function($model) {
        //     dd('updated');
        //     self::aplicarRegras($model);
        // });
        // self::saved(function($model) {
        //     dd('saved');
        //     self::aplicarRegras($model);
        // });
        // self::deleting(function($model) {
        //     dd('deleting');
        //     self::aplicarRegras($model);
        // });
        // self::deleted(function($model) {
        //     dd('deleted');
        //     self::aplicarRegras($model);
        // });
        // self::restoring(function($model) {
        //     dd('restoring');
        //     self::aplicarRegras($model);
        // });
        // self::restored(function($model) {
        //     dd('restored');
        //     self::aplicarRegras($model);
        // });
    }

    public static function scopeAtivos($query, $coluna_nome='ativo')
    {
        return $query->where($coluna_nome, 1);
    }

    public static function getTableName()
    {
        return (new self())->getTable();
    }

    public function regras($ignorar_pk = 0, $dados)
    {
        return $ignorar_pk ? ["id" => "primary_key|unique:$this->model_class,id,$ignorar_pk"] : [];
    }
}
