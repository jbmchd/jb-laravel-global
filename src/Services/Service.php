<?php

namespace JbGlobal\Services;

use App\Exceptions\AppException;
use JbGlobal\Repositories\Repository;
use JbGlobal\Traits\{ TArray, TException, TLog, TValidation, TFile };

abstract class Service
{
    use TArray, TFile, TLog, TValidation;

    protected $repositorio = Repository::class;
    protected $exception_class;

    public function __construct()
    {
        if($this->repositorio){
            $this->repositorio = app($this->repositorio);
        }
    }

    public function buscar(array $colunas = ['*'], $with = [], array $scopes = [])
    {
        $result = $this->repositorio->buscar($colunas, $with, $scopes);
        return $result;
    }

    public function buscarPor($coluna, $valor, $with=[], array $scopes=[])
    {
        $result = $this->repositorio->buscarPor($coluna, $valor, $with, $scopes);
        return $result;
    }

    public function encontrar($id, array $colunas = ['*'], array $scopes=[])
    {
        $result = $this->repositorio->encontrar($id, $colunas, $scopes);
        return $result;
    }

    public function encontrarPor($coluna, $valor, $with=[], array $scopes=[])
    {
        $result = $this->repositorio->encontrarPor($coluna, $valor, $with, $scopes);
        return $result;
    }

    public function ativos()
    {
        return $this->repositorio->ativos();
    }

    protected function jbException($mensagem, $codigo = 500)
    {
        TException::jbException($mensagem, $codigo, $this->exception_class);
    }

}
