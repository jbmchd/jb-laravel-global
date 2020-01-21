<?php

namespace JbGlobal\Traits;

use JbGlobal\Exceptions\AppException;
use Illuminate\Support\Facades\Validator;

trait TValidation
{
    public static function validar(array $dados, array $regras)
    {
        $result = Validator::make($dados, $regras);
        $tem_erro = $result->fails();
        if ($tem_erro) {
            throw new AppException($result->getMessageBag()->first(), 500);
        }
        return true;
    }
}
