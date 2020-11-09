<?php

namespace JbGlobal\Services;

use JbGlobal\Exceptions\AuthException;
use JbGlobal\Repositories\UsuarioRepository as Repository;


class AuthService extends Service
{
    public function __construct(Repository $repositorio)
    {
        parent::__construct($repositorio);
        $this->exception_class = AuthException::class;
    }

}
