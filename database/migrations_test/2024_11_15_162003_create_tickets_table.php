<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('tema');
            $table->text('descripcion');
            $table->string('telefono');
            $table->string('departamento');
            $table->string('ip')->nullable();
            $table->integer('asignado')->nullable();
            $table->string('edificio')->nullable();
            $table->string('usuario_red')->nullable();
            $table->string('autoriza')->nullable();
            $table->integer('creador');
            $table->string('prioridad');
            $table->string('color_prioridad');
            $table->string('categoria')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->integer('usuario');
            $table->string('reporta')->nullable();
            $table->text('comentarios_print')->nullable();
            $table->date('fecha_atencion')->nullable();
            $table->boolean('active')->default(1);
            $table->tinyInteger('unidad_si_no')->nullable();
            $table->string('unidad')->nullable();
            $table->text('last_coment')->nullable();
            $table->string('user_coment')->nullable();
            $table->timestamp('date_coment')->nullable();
            $table->timestamp('date_close')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
