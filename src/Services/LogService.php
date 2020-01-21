<?php

namespace JbGlobal\Services;

use JbGlobal\Repositories\LogRepository;

class LogService extends Service
{
    public function __construct(LogRepository $repositorio)
    {
        $this->repositorio = $repositorio;
    }
}
