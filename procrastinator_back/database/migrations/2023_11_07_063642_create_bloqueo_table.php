<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloqueoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bloqueos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->time('hora_inicio');
            $table->time('duracion');
            $table->string('estado');
            $table->foreignId('id_app');
            $table->foreign('id_app')->references('id')->on('apps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bloqueo');
    }
}
