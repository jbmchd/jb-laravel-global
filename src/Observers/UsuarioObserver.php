<?php

namespace JbGlobal\Observers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use JbGlobal\Models\Usuario;

class UsuarioObserver
{
    /**
     * Handle the usuario "creating" event.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return void
     */
    public function creating(Usuario $usuario)
    {
        $usuario->uuid = Str::uuid();
        $usuario->senha = Hash::make($usuario->senha);
    }

    /**
     * Handle the usuario "creating" event.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return void
     */
    public function updating(Usuario $usuario)
    {
        $usuario->senha = Hash::make($usuario->senha);
    }
}
