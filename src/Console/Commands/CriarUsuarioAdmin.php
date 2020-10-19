<?php

namespace App\Console\Commands;

use JbGlobal\Services\Pessoas\UsuarioAdminService as Service;
use Illuminate\Console\Command;

class CriarUsuarioAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jb-app:criar-admin {email} {senha} {nome_razao}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria usuário com o papel de admin no sistema';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $servico;

    public function __construct(Service $servico)
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
        dd('a');
        $arguments = $this->arguments();
        $options = $this->options();

        $Pessoa = $this->servico->encontrarPessoaPor('email',$arguments['email']);

        if ($Pessoa) {
            $this->error('Já existe uma pessoa com este email.');
            return false;
        }

        $arguments['senha'] = $arguments['senha'];
        $arguments['senha_confirmation'] = $arguments['senha'];

        $dados = array_merge($arguments, $options, ['ativo' => true, 'tipo'=>'POND']);

        try {
            $this->servico->criarComPessoa($dados);
            $this->info('Usuário Administrador criado com sucesso.');
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
            return false;
        }
    }
}
