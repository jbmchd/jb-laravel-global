<?php

namespace JbGlobal\Traits;

use NumberFormatter;

trait TCurrency
{
    static function parseCurrency($valor)
    {
        $valor_formatado = [];
        preg_match_all(TRegex::getCurrencyBr(),$valor, $valor_formatado);
        $valor_formatado = implode('',$valor_formatado[0]);
        $valor_formatado = (float) str_replace(',','.',$valor_formatado);
        return $valor_formatado;
    }

    static function formatCurrency(float $valor)
    {
        $fmt = new NumberFormatter( config('app.locale'), NumberFormatter::CURRENCY );
        $valor_formatado = $fmt->formatCurrency($valor, env('MIX_APP_CURRENCY', env('APP_CURRENCY')));
        return $valor_formatado;
    }
}
