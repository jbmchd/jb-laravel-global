<?php

namespace JbGlobal\Services;

use JbGlobal\Traits\{ TArray, TDiversos, TException, TLog, TValidation, TFile };

abstract class Service
{
    use TArray, TDiversos, TException, TFile, TLog, TValidation;

    protected $repositorio;

    public function todos(array $colunas = ['*'])
    {
        return $this->repositorio->todos($colunas);
    }

    public function buscar($id, array $colunas = ['*'])
    {
        return $this->repositorio->buscar($id, $colunas);
    }

    public function buscarPor($coluna, $valor, $with=[])
    {
        return $this->repositorio->buscarPor($coluna, $valor, $with);
    }

    public function criar(array $dados)
    {
        $dados = $this->criarArrayValido($dados);
        unset($dados['id']);
        $result = $this->validar($dados, $this->regras());
        if ($result['erro']) {
            return $result;
        }
        return $this->repositorio->criar($dados);
    }

    public function atualizar(array $dados, $id=null)
    {
        $dados = $this->criarArrayValido($dados);
        if (!$id) {
            $id = $dados['id'];
        }
        $result = $this->validar($dados, $this->regras($id));
        if ($result['erro']) {
            return $result;
        }
        $result = $this->repositorio->atualizar($dados, $id);
        return $result ? $this->buscar($id) : $result ;
    }

    public function criarArrayValido(array $dados)
    {
        $id = 0;
        if (isset($dados['id'])) {
            $id = (int) $dados['id'];
        }

        $validacao = $this->validar($dados, $this->regras($id));
        if ($validacao['erro']) {
            return $validacao;
        }

        return $this->repositorio->criarArrayValido($dados);
    }

    public function regras($ignorar_id = 0)
    {
        return [];
    }
}
