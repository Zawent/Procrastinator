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
            $table->datetime('hora_inicio');
            $table->time('duracion');
            $table->string('estado');
            $table->foreignId('id_app');
            $table->foreign('id_app')->references('id')->on('apps');
            $table->foreignId('id_user');
            $table->foreign('id_user')->references('id')->on('users') ->onDelete('cascade');
            $table->string('bloqueo_comodin')->default('si');

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
