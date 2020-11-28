<?php

namespace JbGlobal\Requests;

use Illuminate\Support\Arr;

class UsuarioRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        parent::rules();

        $regras = [
            'nome' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'min:3', 'max:255', 'email'],
            'senha' => ['required', 'string', 'min:6', 'max:255'],
        ];

        $regras_selecionadas = [];
        switch ($this->getMetodo()) {
            case 'entrar':
                $regras_selecionadas = Arr::add($regras_selecionadas, 'email', $regras['email']);
                $regras_selecionadas = Arr::add($regras_selecionadas, 'senha', $regras['senha']);
                break;
            case 'registrar':
                $regras_selecionadas = Arr::add($regras_selecionadas, 'nome', $regras['nome']);
                $regras_selecionadas = Arr::add($regras_selecionadas, 'email', array_merge($regras['email'], ["unique:usuarios,email"]));
                $regras_selecionadas = Arr::add($regras_selecionadas, 'senha', array_merge($regras['senha'], ['confirmed']));
                break;
            case 'atualizar':
                $id = $this->getParametros()->id;

                $regras_selecionadas = Arr::add($regras_selecionadas, 'nome', $regras['nome']);
                $regras_selecionadas = Arr::add($regras_selecionadas, 'email', array_merge($regras['email'], ["unique:usuarios, email, $id"]));
                $regras_selecionadas = Arr::add($regras_selecionadas, 'senha', $regras['senha']);

                if ($this->senha) {
                    $regras_selecionadas = Arr::add($regras_selecionadas, 'senha', array_merge($regras['senha'], ['confirmed']));
                }

                break;
        }
        return $regras_selecionadas;
    }
}
