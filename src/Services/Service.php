<?php

namespace JbGlobal\Services;

use JbGlobal\Traits\{ TArray, TDiversos, TException, TLog, TValidation, TFile, TSessao };

abstract class Service
{
    use TArray, TDiversos, TException, TFile, TLog, TValidation, TSessao;
}
