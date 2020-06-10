<?php

namespace JbGlobal\Traits;

trait TDiversos
{
    protected static function criarRetornoController($dados, $mensagens='')
    {
        $retorno['dados'] = $dados;
        $retorno['mensagens'] = $mensagens;

        return $retorno;
    }
}
