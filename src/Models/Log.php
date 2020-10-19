<?php

namespace JbGlobal\Models;

class Log extends Model
{
    protected $fillable = [
        'id', 'usuario_id', 'nivel', 'tipo', 'mensagem', 'arquivo', 'linha', 'caminho', 'acao', 'dados'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
