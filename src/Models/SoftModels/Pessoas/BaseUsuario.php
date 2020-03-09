<?php
namespace JbGlobal\Models\SoftModels\Pessoas;

use JbGlobal\Models\Usuario;
use JbGlobal\Models\Scopes\UsuarioPapeisScope;

class BaseUsuario extends Usuario
{
    public $table = 'usuarios';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UsuarioPapeisScope);
    }

    public function getPapel()
    {
        return $this->papel;
    }


}

