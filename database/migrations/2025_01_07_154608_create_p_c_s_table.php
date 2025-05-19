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
        Schema::create('pcs', function (Blueprint $table) {
            $table->id();
            $table->integer('equipo_id');
            $table->string('ram')->nullable();
            $table->string('hdd')->nullable();
            $table->string('sdd')->nullable();
            $table->string('sistema_operativo')->nullable();
            $table->string('usuario')->nullable();
            $table->string('usuario_red')->nullable();
            $table->string('monitores')->nullable();
            $table->string('nombre_equipo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pcs');
    }
};
