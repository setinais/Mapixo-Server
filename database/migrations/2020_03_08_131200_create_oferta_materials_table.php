<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfertaMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oferta_materials', function (Blueprint $table) {
            $table->id();
            $table->integer('classificacao_id');
            $table->integer('user_id');
            $table->integer('unidade_medida_id');
            $table->integer('localizacao_id')->nullable();
            $table->string('nome');
            $table->string('descricao');
            $table->string('qntd');
            $table->string('foto')->nullable();
            $table->boolean('status')->default(false);
            $table->string('valor')->nullable();
            $table->enum('tipo_negociacao', ['Venda', 'Doação', 'Reciclagem'])->default('Reciclagem');
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
        Schema::dropIfExists('oferta_materials');
    }
}
