<?php

namespace JbGlobal\Repositories\Pessoas;

use JbGlobal\Models\SoftModels\Pessoas\UsuarioAdm as Model;

class UsuarioAdminRepository extends UsuarioRepository
{
    private $papel;

    public function __construct(Model $model, PessoaRepository $pessoa_repository)
    {
        parent::__construct($model, $pessoa_repository);
        $this->papel = $model::PAPEL_ADMINISTRADOR;
    }
}
