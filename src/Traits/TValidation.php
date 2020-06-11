<?php

namespace JbGlobal\Traits;

use Illuminate\Support\Facades\Validator;
use JbGlobal\Exceptions\ModelException;

trait TValidation
{
    public static function validar(array $dados, array $regras, $lancar_excecao=true)
    {
        $result = Validator::make($dados, $regras);
        $tem_erro = $result->fails();
        if ($tem_erro) {
            if($lancar_excecao){
                throw new ModelException($result->getMessageBag()->first(), 500);
            }
            else {
                return $result->getMessageBag()->first();
            }

        }
        return true;
    }
}
