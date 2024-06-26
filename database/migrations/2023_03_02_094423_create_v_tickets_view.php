<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVTicketsView extends Migration
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
            CREATE VIEW `v_tickets` AS select `tickets`.`tema` AS `tema`,`tickets`.`descripcion` AS `descripcion`,`tickets`.`telefono` AS `telefono`,if(`tickets`.`edificio` = '','SIN EDIFICIO',`tickets`.`edificio`) AS `edificio`,`tickets`.`ip` AS `ip`,if(`tickets`.`asignado` is null,'SIN ASIGNAR',concat_ws(' ',`asignados`.`name`,`asignados`.`lastname`)) AS `asignado`,if(`tickets`.`departamento` = '','SIN DEPARTAMENTO',`tickets`.`departamento`) AS `departamento`,if(`tickets`.`categoria` = '','SIN CATEGORIA',`tickets`.`categoria`) AS `categoria`,`tickets`.`status` AS `status`,`tickets`.`created_at` AS `created_at`,`tickets`.`updated_at` AS `updated_at` from (`tickets` left join `users` `asignados` on(`tickets`.`asignado` = `asignados`.`id`))
        SQL;
    }

    private function dropView()
    {
        return <<<SQL
            DROP VIEW IF EXISTS `v_tickets`;
        SQL;
    }
}
