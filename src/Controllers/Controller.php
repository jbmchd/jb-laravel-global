<?php

namespace JbGlobal\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use JbGlobal\Traits\{ TArray, TDiversos, TException, TFile, TLog, TString, TValidation };

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use TArray, TDiversos, TException, TFile, TLog, TString, TValidation;

    protected $servico;

    public function buscar()
    {
        $result = $this->servico->buscar();
        $retorno = self::criarRetornoController($result);
        return $retorno;
    }

    public function encontrar($id)
    {
        $result = $this->servico->encontrar($id);
        $retorno = self::criarRetornoController($result);
        return $retorno;
    }

    public function criar(Request $request)
    {
        $dados = $request->all();
        $result = $this->servico->criar($dados);
        $retorno = self::criarRetornoController($result, 'Registro inserido com sucesso.');
        return $retorno;
    }

    public function atualizar(Request $request, $id)
    {
        $dados = $request->all();
        $result = $this->servico->atualizar($dados, $id);
        $retorno = self::criarRetornoController($result, 'Registro atualizado com sucesso.');
        return $retorno;
    }

    public function deletar($id)
    {
        $result = $this->servico->deletar($id);
        $retorno = self::criarRetornoController($result, 'Registro deletado com sucesso.');
        return $retorno;
    }
}
