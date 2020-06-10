<?php

namespace JbGlobal\Exceptions;

/**
* AppException
*/
class AppException extends \Exception
{
    const LOG_NIVEL_EMERGENCY = 'emergency';
    const LOG_NIVEL_ALERT = 'alert';
    const LOG_NIVEL_CRITICAL = 'critical';
    const LOG_NIVEL_ERROR = 'error';
    const LOG_NIVEL_WARNING = 'warning';
    const LOG_NIVEL_NOTICE = 'notice';
    const LOG_NIVEL_INFO = 'informational';
    const LOG_NIVEL_DEBUG = 'debug';

    protected $nivel = self::LOG_NIVEL_CRITICAL;

    public function getLogNivel(){
        return $this->nivel;
    }
}
