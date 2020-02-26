<?php

namespace JbGlobal\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

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

    public static function scopeAtivos($query, $coluna_nome='ativo')
    {
        return $query->where($coluna_nome, 1);
    }

    public static function getTableName()
    {
        return (new self())->getTable();
    }
}
