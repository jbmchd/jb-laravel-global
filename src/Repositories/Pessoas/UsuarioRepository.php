<?php

namespace JbGlobal\Repositories\Pessoas;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use JbGlobal\Models\Pessoa;
use JbGlobal\Models\Usuario as Model;
use JbGlobal\Repositories\Repository;

class UsuarioRepository extends Repository
{
    public $pessoa_repository;

    public function __construct(Model $model, PessoaRepository $pessoa_repository)
    {
        parent::__construct($model);
        $this->pessoa_repository = $pessoa_repository;
    }

    public function criarModelValido(array $dados, $ignorar_pk=0)
    {
        $dados[$this->model->getKeyName()] = $ignorar_pk;
        $validacao = $this->validar($dados, self::regras($ignorar_pk));
        if ($validacao['erro']) {
            return $validacao;
        }
        $dados['senha'] = $this->criarSenha($dados['senha']);
        return $this->model->fill($dados);
    }

    public function criarComPessoa(array $dados)
    {
        DB::beginTransaction();
        $pessoa = $this->pessoa_repository->criar($dados);
        $dados['pessoa_id'] = $pessoa->id;
        $dados['papel'] = $this->model->getPapel();
        $this->criar($dados);
        db::commit();
        return $pessoa;
    }

    public function alterarSenha($usuario_id, $senha_hash)
    {
        $usuario = $this->model->find($usuario_id);
        $usuario->update(['senha' => $senha_hash]);
        return $usuario;
    }

    public function criarSenha($string)
    {
        return Hash::make($string);
    }

    public function regras($ignorar_pk = 0, $dados = [])
    {
        $pessoas_class = Pessoa::class;
        $regras = [
            'senha' => ['required', 'string', 'min:6', 'confirmed']
        ];

        if ($ignorar_pk) {
            $regras = array_merge($regras, [
                "pessoa_id" => "required|foreign_key:$pessoas_class|unique:$this->model_class,id,$ignorar_pk",
                "papel" => "required|in:SU,ADM,SUP",
            ]);
        }

        return array_merge($regras, parent::regras($ignorar_pk, $dados));
    }
}
