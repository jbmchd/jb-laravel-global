<?php

namespace JbGlobal\Models;

class Log extends Model
{
    protected $fillable = [
        'id', 'usuario_id', 'nivel', 'tipo', 'mensagem', 'arquivo', 'linha', 'trace', 'action', 'dados', 'created_at', 'updated_at'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
