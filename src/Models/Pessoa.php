<?php

namespace JbGlobal\Models;

class Pessoa extends Model
{
    protected $fillable = [
        'id','nome','email','email_verificado_em','ativo'
    ];

    public function usuario()
    {
        return $this->hasOne(Usuario::class);
    }

    public function password_reset()
    {
        return $this->hasOne(PasswordReset::class, 'email', 'email');
    }
}
