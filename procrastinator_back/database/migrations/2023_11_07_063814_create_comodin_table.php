<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComodinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comodins', function (Blueprint $table) {
            $table->id();
            $table->datetime('tiempo_generacion');
            $table->timestamps();
            $table->foreignId('id_bloqueo');
            $table->foreign('id_bloqueo')->references('id')->on('bloqueos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comodins');
    }
}