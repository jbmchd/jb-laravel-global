<?php

namespace JbGlobal\Services;

use JbGlobal\Repositories\LogRepository;

class LogService extends CrudService
{
    protected $repositorio = LogRepository::class;
}
