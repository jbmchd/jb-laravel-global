<?php

namespace JbGlobal\Models;

class Usuario extends Model
{
    const PAPEL_SUPER = 'SUP';
    const PAPEL_ADMIN = 'ADM';
    const PAPEL_USUARIO = 'USR';

    protected $fillable = [
        'id','pessoa_id','papel','senha','remember_token','ativo'
    ];

    protected $hidden = [
        'senha', 'remember_token', 'deleted_at'
    ];

    protected $casts = [
        'email_verificado_em' => 'datetime',
        'pessoa_id' => 'integer'
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }
    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public static function scopeSupers($query)
    {
        return $query->where('papel', self::PAPEL_SUPER);
    }

    public static function scopeAdmins($query)
    {
        return $query->where('papel', self::PAPEL_ADMIN);
    }

    public static function scopeUsuarios($query)
    {
        return $query->where('papel', self::PAPEL_USUARIO);
    }

}
