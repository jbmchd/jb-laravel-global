<?php

namespace JbGlobal\Traits;

trait TSessao
{
    public static function getSessionKey(){
        $pessoa = auth()->user();
        return $pessoa->id ? 'usuario_' . $pessoa->id : 'app' ;
    }

    static function session($key=null, $default=null){
        $key_principal = self::getSessionKey();
        if(is_array($key)) $key = [$key_principal => $key];
        else if(is_null($key)) $key = $key_principal;
        else $key = $key_principal.'.'.$key;

        return session($key, $default);
    }
}
