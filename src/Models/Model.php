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

    public static function scopeAtivos($query, $coluna_nome='ativo')
    {
        return $query->where($coluna_nome, 1);
    }

    public static function getTableName()
    {
        return (new self())->getTable();
    }
}
