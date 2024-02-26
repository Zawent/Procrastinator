<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user');
            $table->foreign('id_user')->references('id')->on('users')  ->onDelete('cascade');
            $table->integer('respuesta')->nullable();
            $table->foreignId('id_nivel')->nullable();
            $table->foreign('id_nivel')->references('id')->on('nivels') ->onDelete('cascade');
            $table->foreignId('id_pregunta')->nullable();
            $table->foreign('id_pregunta')->references('id')->on('preguntas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respuesta');
    }
}
