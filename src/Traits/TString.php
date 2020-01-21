<?php

namespace JbGlobal\Traits;

trait TString
{
    public static function desacentuar($string)
    {
        return preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));
    }

    public static function criarNomeUnicoDatetime($nome_base=null, $separador=null)
    {
        $datetime_now = (new \Datetime())->format('YmdHisu');
        return $nome_base.$separador.$datetime_now;
    }
}
