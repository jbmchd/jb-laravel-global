<?php

namespace JbGlobal\Models;

class PasswordReset extends Model
{
    const CREATED_AT = 'created_at';

    protected $fillable = [
        'email','token',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }
}
