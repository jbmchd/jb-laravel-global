<?php

namespace JbGlobal\Console\Commands;

use JbGlobal\Services\UsuarioService;
use Illuminate\Console\Command;

class CriarUsuarioCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jb-app:criar-usuario {email} {senha} {nome}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria usuário no sistema default';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $servico;

    public function __construct(UsuarioService $servico)
    {
        parent::__construct();
        $this->servico = $servico;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arguments = $this->arguments();
        $options = $this->options();

        $arguments['senha_confirmation'] = $arguments['senha'];

        try {
            $this->servico->criar($arguments);
            $this->info('Usuário default criado com sucesso.');
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
            return false;
        }
    }
}
