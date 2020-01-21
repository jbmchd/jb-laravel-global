<?php

namespace JbGlobal\Services;

use JbGlobal\Repositories\PessoaRepository;

class PessoaService extends Service
{
    protected $usuario_servico;

    public function __construct(PessoaRepository $repositorio, UsuarioService $usuario_servico = null)
    {
        $this->repositorio = $repositorio;
        $this->usuario_servico = $usuario_servico;
    }

    public function encontrar($id, array $colunas = ['*'])
    {
        return $this->repositorio->encontrar($id);
    }

    public function cadastrarComUsuario(array $dados)
    {
        unset($dados['id']);
        $pessoa = $this->criarArrayValido($dados);
        $usuario = $this->usuario_servico->criarArrayValido($dados);
        $usuario = $this->usuario_servico->preparar($usuario);
        return $this->repositorio->cadastrarComUsuario($pessoa, $usuario);
    }

    public function atualizarComUsuario(array $dados)
    {
        $pessoa = self::criarArrayValido($dados);
        if (isset($pessoa['erro'])) {
            return $pessoa;
        } else {
            $usuario = $this->usuario_servico->criarArrayValido($dados);
            if (isset($usuario['erro'])) {
                return $usuario;
            } else {
                $usuario = $this->usuario_servico->preparar($usuario);
                return $this->repositorio->atualizarComUsuario($pessoa, $usuario);
            }
        }
    }

    public function regras($ignorar_id = 0)
    {
        $regras = [
            "cpf" => "nullable|string|cpf",
            "nome" => "nullable|string|max:255",
            "email" => "nullable|string|email|max:255|unique:pessoas,email,$ignorar_id,id",
            "papel" => "required|in:ADM,REP,PRE",
            "ativo" => "required|boolean",
        ];

        if ($ignorar_id) {
            $regras = array_merge($regras, ["id" => "required|numeric|min:1|unique:pessoas,id,$ignorar_id,id",]);
        }

        return $regras;
    }
}
