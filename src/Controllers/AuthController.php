<?php

namespace JbGlobal\Controllers;

use JbGlobal\Controllers\Controller;
use JbGlobal\Services\AuthService;

class AuthController extends Controller
{
    protected $servico = AuthService::class;
    protected $exception_class = AuthException::class;
}
