<?php

namespace JbGlobal\Controllers;

use JbGlobal\Controllers\Controller;
use JbGlobal\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(AuthService $authService)
    {
        parent::__construct($authService);
        $this->exception_class = AuthException::class;
    }
}
