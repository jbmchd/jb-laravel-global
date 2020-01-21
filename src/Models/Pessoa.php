<?php

namespace JbGlobal\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pessoa extends Authenticatable
{
    use Notifiable;

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
