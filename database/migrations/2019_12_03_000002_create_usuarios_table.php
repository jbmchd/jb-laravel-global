<?php

use JbGlobal\Database\BlueprintExt;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pessoa_id')->unsigned();
            $table->string('papel', 5)->comment('SUP => super, ADM => admin','USR => user');
            $table->string('senha');
            $table->boolean('ativo')->default(true);

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            (new BlueprintExt($table))->foreign('pessoa_id', 'pessoas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
