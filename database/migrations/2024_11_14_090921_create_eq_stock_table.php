<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('eq_stock', function (Blueprint $table) {
            $table->id();
            $table->integer('alm_id');
            $table->string('et')->nullable();; //etiqueta
            $table->string('tipo')->nullable();;
            $table->text('not')->nullable(); //nota
            $table->string('tip_id')->nullable();; //tipo de identificador
            $table->integer('user_created_id')->nullable(); //usuario que lo creo
            $table->integer('user_updated_id')->nullable(); //usuario que lo actualiza
            $table->string('condicion')->nullable();
            $table->boolean('asignado')->nullable();
            $table->boolean('deleted')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eq_stock');
    }
};
