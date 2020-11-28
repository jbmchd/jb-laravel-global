<?php

namespace JbGlobal\Repositories;

use JbGlobal\Models\Usuario as Model;

class UsuarioRepository extends CrudRepository
{
    protected $model = Model::class;

    public function buscarUsuarioEmail(String $email)
    {
        $usuario = $this->model->where(['email'=>$email])->first();
        return $usuario;
    }

}
