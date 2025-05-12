<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEqStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eq_stock', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('alm_id')->nullable();
            $table->string('et', 50)->nullable();
            $table->string('tip', 50)->nullable();
            $table->text('not')->nullable();
            $table->string('tip_id', 50)->nullable();
            $table->integer('user_created_id')->nullable();
            $table->integer('user_updated_id')->nullable();
            $table->timestamps()->default('current_timestamp()');
            $table->tinyInteger('asignado')->nullable();
            $table->tinyInteger('deleted')->nullable();
            $table->string('condicion', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eq_stock');
    }
}
