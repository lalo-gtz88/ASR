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
        Schema::create('enlaces', function (Blueprint $table) {
            $table->id();
            $table->integer('sitio_id');
            $table->string('referencia');
            $table->string('descripcion');
            $table->string('telefono');
            $table->string('status');
            $table->string('domicilio');
            $table->integer('proveedor_id');
            $table->string('contacto')->nullable();
            $table->string('tipo')->nullable();
            $table->string('servicios')->nullable();
            $table->string('area')->nullable();
            $table->text('observaciones')->nullable();
            $table->decimal('lat')->nullable();
            $table->decimal('lng')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enlaces');
    }
};
