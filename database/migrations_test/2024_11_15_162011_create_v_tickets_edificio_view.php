<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVTicketsEdificioView extends Migration
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
            CREATE VIEW `v_tickets_edificio` AS select if(`tickets`.`edificio` is null,'SIN EDIFICIO',`tickets`.`edificio`) AS `edificio`,count(`tickets`.`edificio`) AS `num_tickets` from `tickets` where `tickets`.`active` = 1 and (`tickets`.`status` = 'abierto' or `tickets`.`status` = 'pendiente') group by `tickets`.`edificio`
        SQL;
    }

    private function dropView()
    {
        return <<<SQL
            DROP VIEW IF EXISTS `v_tickets_edificio`;
        SQL;
    }
}
