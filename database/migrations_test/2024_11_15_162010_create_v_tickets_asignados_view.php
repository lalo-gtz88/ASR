<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVTicketsAsignadosView extends Migration
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
            CREATE VIEW `v_tickets_asignados` AS select if(`tickets`.`asignado` is null,'SIN ASIGNAR',concat_ws(' ',`asignados`.`name`,`asignados`.`lastname`)) AS `asignado`,count(if(`tickets`.`status` = 'abierto',1,NULL)) AS `abiertos`,count(if(`tickets`.`status` = 'pendiente',1,NULL)) AS `pendientes` from (`tickets` left join `users` `asignados` on(`tickets`.`asignado` = `asignados`.`id`)) where `tickets`.`active` = 1 and `asignados`.`id` <> 3 group by `tickets`.`asignado`
        SQL;
    }

    private function dropView()
    {
        return <<<SQL
            DROP VIEW IF EXISTS `v_tickets_asignados`;
        SQL;
    }
}
