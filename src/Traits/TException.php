<?php

namespace JbGlobal\Traits;

use JbGlobal\Exceptions\AppException;

trait TException
{
    protected static function exception($mensagem, $codigo=500)
    {
        throw new AppException($mensagem, $codigo);
    }

    public static function criarExceptionMessageCompleta(\Exception $exc)
    {
        return "{$exc->getMessage()} | Cod: {$exc->getCode()} | File: {$exc->getFile()} | Line: {$exc->getLine()}" ;
    }
}
