<?php

namespace JbGlobal\Models;

class PasswordReset extends Model
{
    protected $fillable = [
        'email','token',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }
}
