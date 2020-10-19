<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('usuario_id')->constrained()->nullable();

            $table->string('nivel', 500);
            $table->string('tipo', 500);
            $table->string('mensagem', 1000);
            $table->string('arquivo', 1000);
            $table->string('linha', 1000);
            $table->string('caminho', 10000);
            $table->string('acao', 1000);
            $table->json('dados')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
