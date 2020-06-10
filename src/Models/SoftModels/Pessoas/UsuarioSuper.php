<?php
namespace JbGlobal\Models\SoftModels\Pessoas;

use JbGlobal\Models\Usuario;

class UsuarioSuper extends BaseUsuario
{
    protected $papel = Usuario::PAPEL_SUPER;

}

