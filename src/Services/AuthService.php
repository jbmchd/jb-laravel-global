<?php

namespace JbGlobal\Services;

use JbGlobal\Exceptions\AuthException;
use JbGlobal\Repositories\UsuarioRepository as Repository;


class AuthService extends Service
{
    protected $repositorio = Repository::class;
    protected $exception_class = AuthException::class;
}
