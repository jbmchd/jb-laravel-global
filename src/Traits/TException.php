<?php

namespace JbGlobal\Traits;

trait TException
{
    public static function jbException($mensagem, $codigo = 500, $exception_class = AppException::class)
    {
        throw new $exception_class($mensagem, $codigo);
    }

    public static function criarExceptionMessageCompleta(\Exception $exc)
    {
        return "{$exc->getMessage()} | Cod: {$exc->getCode()} | File: {$exc->getFile()} | Line: {$exc->getLine()}" ;
    }
}
