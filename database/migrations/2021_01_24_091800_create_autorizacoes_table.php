<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorizacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizacoes', function (Blueprint $table) {
            $table->increments('AUTORIZACAO_ID', 11);
            $table->integer('USUARIO_ID')->unsigned();
            $table->string('CHAVE_AUTORIZACAO', 100);
            $table->foreign('USUARIO_ID')
                    ->references('USUARIO_ID')->on('usuarios')
                    ->onDelete('cascade');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autorizacoes');
    }
}
