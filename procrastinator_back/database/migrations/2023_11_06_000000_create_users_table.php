<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('fecha_nacimiento');
            $table->string('ocupacion');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->foreignId('id_rol');
            $table->foreign('id_rol')->references('id')->on('rols') ->onDelete('cascade');
            $table->foreignId('nivel_id')->nullable();
            $table->foreign('nivel_id')->references('id')->on('nivels') ->onDelete('cascade');
            ;    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
