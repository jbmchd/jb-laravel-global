<?php

namespace JbGlobal\Controllers;

use App\Exceptions\AuthException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use JbGlobal\Traits\{ TArray, TDiversos, TException, TFile, TLog, TString, TValidation };

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use TArray, TFile, TLog, TString, TValidation;

    protected $servico;
    protected $exception_class;

    public function __construct($servico=null)
    {
        $this->servico = $servico;
        $this->exception_class = AuthException::class;
    }

    public function buscarDadosIniciais()
    {
        $result = $this->servico->buscar();
        $mensagem = 'Operação realizada com sucesso.';
        return response()->jbSuccess($result, $mensagem);
    }

    public function buscar()
    {
        $result = $this->servico->buscar();
        $mensagem = 'Operação realizada com sucesso.';
        return response()->jbSuccess($result, $mensagem);
    }

    public function encontrar($id)
    {
        $result = $this->servico->encontrar($id);
        $mensagem = 'Operação realizada com sucesso.';
        return response()->jbSuccess($result, $mensagem);
    }

    protected function jbException($mensagem, $codigo = 500)
    {
        TException::jbException($mensagem, $codigo, $this->exception_class);
    }


}
