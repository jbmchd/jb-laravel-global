<?php

namespace JbGlobal\Services;

use JbGlobal\Repositories\UsuarioRepository as Repository;
use JbGlobal\Services\CrudService as Service;

class UsuarioService extends Service
{
    protected $repositorio = Repository::class;
}
