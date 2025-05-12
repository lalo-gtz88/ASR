<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeguimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimientos', function (Blueprint $table) {
            $table->id();
            $table->text('notas')->nullable();
            $table->string('ticket', 50);
            $table->integer('usuario');
            $table->string('file')->nullable();
            $table->timestamps()->default('current_timestamp()');
            $table->bit('print', 1)->nullable();
            $table->bit('unido', 1)->nullable();
            $table->integer('id_diagnostico')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seguimientos');
    }
}
