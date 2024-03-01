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
            $table->time('tiempo_generacion');
            $table->foreignId('id_user');
            $table->foreign('id_user')->references('id')->on('users')  ->onDelete('cascade');
            $table->string('estado')->default('disponible');
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
