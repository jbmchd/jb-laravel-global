<?php

namespace JbGlobal\Exceptions;

/**
* AppException
*/
class ModelException extends AppException
{
    protected $nivel = parent::LOG_NIVEL_CRITICAL;

    public function getLogNivel(){
        return $this->nivel;
    }
}
