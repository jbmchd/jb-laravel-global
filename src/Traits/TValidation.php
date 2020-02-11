<?php

namespace JbGlobal\Traits;

use JbGlobal\Exceptions\AppException;
use Illuminate\Support\Facades\Validator;

trait TValidation
{
    public static function validar(array $dados, array $regras, $lancar_excecao=true)
    {
        $result = Validator::make($dados, $regras);
        $tem_erro = $result->fails();
        if ($tem_erro) {
            if($lancar_excecao){
                throw new AppException($result->getMessageBag()->first(), 500);
            }
            else {
                return $result->getMessageBag()->first();
            }

        }
        return true;
    }
}
