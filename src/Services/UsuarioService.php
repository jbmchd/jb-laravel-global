<?php

namespace JbGlobal\Services;

use JbGlobal\Repositories\UsuarioRepository;
use Illuminate\Support\Facades\Hash;

class UsuarioService extends Service
{
    public function __construct(UsuarioRepository $repositorio)
    {
        $this->repositorio = $repositorio;
    }

    public function preparar(array $usuario)
    {
        $usuario['senha'] = self::criarSenha($usuario['senha']);
        return $usuario;
    }

    public function criarSenha($string)
    {
        return Hash::make($string);
    }

    public function regras($ignorar_id=0)
    {
        $regras = [
            'senha' => ['required', 'string', 'min:6', 'confirmed']
        ];

        if ($ignorar_id) {
            $regras = array_merge($regras, [
                "id" => "required|numeric|min:1|unique:usuarios,id,$ignorar_id,id",
                "pessoa_id" => "integer|unique:usuarios,pessoa_id,$ignorar_id,id",
            ]);
        }

        return $regras;
    }
}
