<?php
namespace JbGlobal\Models\SoftModels\Pessoas;

use JbGlobal\Models\Usuario;

class UsuarioSuporte extends BaseUsuario
{
    protected $papel = Usuario::PAPEL_SUPORTE;
}

