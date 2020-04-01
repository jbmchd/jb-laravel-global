<?php

namespace JbGlobal\Traits;

trait TRegex
{

    private static $currency_br = '/\d+|,(\.\d{3})*(,\d+)?/';

    static function getCurrencyBr(){
        return self::$currency_br;
    }
}
