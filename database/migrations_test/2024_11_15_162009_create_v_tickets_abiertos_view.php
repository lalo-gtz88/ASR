<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVTicketsAbiertosView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->dropView());
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());
    }

    private function createView()
    {
        return <<<SQL
            CREATE VIEW `v_tickets_abiertos` AS select `tickets`.`id` AS `id`,if(`tickets`.`asignado` is null,'SIN ASIGNAR',concat_ws(' ',`asignados`.`name`,`asignados`.`lastname`)) AS `asignado`,`tickets`.`status` AS `status` from (`tickets` left join `users` `asignados` on(`tickets`.`asignado` = `asignados`.`id`)) where `tickets`.`status` = 'Abierto'
        SQL;
    }

    private function dropView()
    {
        return <<<SQL
            DROP VIEW IF EXISTS `v_tickets_abiertos`;
        SQL;
    }
}
