<?php
namespace JbGlobal\Models\SoftModels\Pessoas;

use JbGlobal\Models\Usuario;

class UsuarioAdm extends BaseUsuario
{
    protected $papel = Usuario::PAPEL_ADMINISTRADOR;

}

