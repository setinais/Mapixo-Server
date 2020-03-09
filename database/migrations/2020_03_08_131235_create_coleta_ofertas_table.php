<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColetaOfertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coleta_ofertas', function (Blueprint $table) {
            $table->id();
            $table->integer('oferta_material_id');
            $table->integer('user_id');
            $table->enum('status', ['Finalizado', 'Aguardando Coleta', 'Rejeitado']);
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
        Schema::dropIfExists('coleta_ofertas');
    }
}
