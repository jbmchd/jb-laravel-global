<?php

namespace JbGlobal\Requests;

class AuthRequest extends Request
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
            'token' => ['required', 'string', 'min:3', 'max:255'],
            'nome' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'min:3', 'max:255', 'email'],
            'senha' => ['required', 'string', 'min:6', 'max:255'],
        ];

        $regras_selecionadas = [];
        switch ($this->getMetodo()) {
            case 'entrar':
                $regras_selecionadas['email'] = array_merge($regras['email'], ["exists:usuarios"]);
                $regras_selecionadas['senha'] = $regras['senha'];
                break;
            case 'registrar':
                $regras_selecionadas['nome'] = $regras['nome'];
                $regras_selecionadas['email'] = array_merge($regras['email'], ["unique:usuarios,email"]);
                $regras_selecionadas['senha'] = array_merge($regras['senha'], ['confirmed']);
                break;
            case 'enviarEmailRecuperarSenha':
                $regras_selecionadas['email'] = array_merge($regras['email'], ["exists:usuarios"]);
                break;
            case 'trocarSenha':
                $regras_selecionadas['email'] = array_merge($regras['email'], ["exists:usuarios"]);
                $regras_selecionadas['senha'] = array_merge($regras['senha'], ['confirmed']);
                $regras_selecionadas['token'] = $regras['token'];
                break;
        }
        return $regras_selecionadas;
    }
}
