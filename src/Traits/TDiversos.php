<?php

namespace JbGlobal\Traits;

trait TDiversos
{
    public static $retorno_padrao = ['dados'=>[], 'mensagens'=>[], 'code'=>200];

    protected static function criarRetornoController($dados, $mensagens='', int $code=200, array $exception=[])
    {
        $retorno = self::$retorno_padrao;

        $retorno['dados'] = $dados;
        $retorno['mensagens'] = $mensagens;
        $retorno['code'] = $code;
        $retorno['erro'] = $code<200 || $code>=300;

        return $retorno;
    }
}
