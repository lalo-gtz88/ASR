<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('st')->unique();
            $table->string('nombre')->nullable();
            $table->string('usuario')->nullable();
            $table->string('nombre_usuario')->nullable();
            $table->string('dsi')->nullable();
            $table->string('so')->nullable();
            $table->string('internet')->nullable();
            $table->string('nivel_internet')->nullable();
            $table->string('mac')->nullable();
            $table->integer('nodo')->nullable();
            $table->integer('user');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipos');
    }
};
