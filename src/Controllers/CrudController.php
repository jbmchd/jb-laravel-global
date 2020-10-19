<?php

namespace JbGlobal\Controllers;

use Illuminate\Http\Request;
use JbGlobal\Services\Service;

class CrudController extends Controller
{
    public function __construct(Service $servico)
    {
        parent::__construct($servico);
    }

    public function criar(Request $request)
    {
        $dados = $request->all();
        $result = $this->servico->criar($dados);
        $mensagem = 'Registro inserido com sucesso.';
        return response()->jbSuccess($result, $mensagem);
    }

    public function atualizar(Request $request, $id)
    {
        $dados = $request->all();
        $result = $this->servico->atualizar($dados, $id);
        $mensagem = $result ? 'Registro atualizado com sucesso.' : 'Operação realizada, mas nenhum registro alterado.';
        return response()->jbSuccess($result, $mensagem);
    }

    public function deletar($id)
    {
        $result = $this->servico->deletar($id);
        $mensagem = $result ? 'Registro deletado com sucesso.' : 'Operação realizada, mas nenhum registro deletado.';
        return response()->jbSuccess($result, $mensagem);
    }
}
