<?php

namespace JbGlobal\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use JbGlobal\Traits\{ TArray, TDiversos, TException, TFile, TLog, TString, TValidation, TSessao };

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use TArray, TDiversos, TException, TFile, TLog, TString, TValidation, TSessao;

    protected $servico;

    public function __construct($servico)
    {
        $this->servico = $servico;
    }

}
