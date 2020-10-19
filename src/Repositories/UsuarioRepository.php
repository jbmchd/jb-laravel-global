<?php

namespace JbGlobal\Repositories;

use JbGlobal\Models\Usuario as Model;

class UsuarioRepository extends CrudRepository
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

    public function buscarUsuarioEmail(String $email)
    {
        $usuario = $this->model->where(['email'=>$email])->first();
        return $usuario;
    }

}
