<?php

namespace JbGlobal\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register the application's response macros.
     *
     * @return void
     */
    public function boot()
    {
        $padronizarRetornoMethod=function ($dados, $mensagens=null, $tipo='app') {
            return $this->padronizarRetorno($dados, $mensagens, $tipo);
        };

        Response::macro('jbApp', function ($dados, $mensagens=null, $tipo='app') use ($padronizarRetornoMethod) {
            $retorno=$padronizarRetornoMethod($dados, $mensagens, $tipo);
            return Response::make($retorno);
        });

        Response::macro('jbSuccess', function ($dados, $mensagens=null) use ($padronizarRetornoMethod) {
            $retorno=$padronizarRetornoMethod($dados, $mensagens, 'success');
            return Response::make($retorno);
        });

        Response::macro('jbError', function ($dados, $mensagens=null) use ($padronizarRetornoMethod) {
            $retorno=$padronizarRetornoMethod($dados, $mensagens, 'error');
            return Response::make($retorno);
        });
    }

    public function padronizarRetorno($dados, $mensagens=null, $tipo='app')
    {
        if(!$mensagens){
            switch ($tipo) {
                case 'success':
                    $mensagens = 'Operação realizada com success';
                    break;
                case 'error':
                    $mensagens = 'Ocorreu algum problema.';
                    break;
            }
        }

        $mensagens = (array) $mensagens;

        $retorno=[
            'dados' => $dados,
            'mensagens' => $mensagens,
        ];

        return $retorno;
    }

}
