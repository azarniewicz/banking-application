<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KredytyView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("
            CREATE
        ALGORITHM = UNDEFINED
        DEFINER = `root`@`localhost`
        SQL SECURITY DEFINER
    VIEW `v_biezace_kredyty` AS
        SELECT
            `kredyty`.`id_kredytu` AS `id_kredytu`,
            `kredyty`.`id_klienta` AS `id_klienta`,
            `kredyty`.`data_wniosku` AS `data_wniosku`,
            `kredyty`.`data_zakonczenia_wniosku` AS `data_zakonczenia_wniosku`,
            `kredyty`.`kwota_kredytu` AS `kwota_kredytu`,
            `kredyty`.`oprocentowanie` AS `oprocentowanie`,
            `kredyty`.`zgoda_odmowa` AS `zgoda_odmowa`,
            `kredyty`.`ilosc_rat` AS `ilosc_rat`,
            `kredyty`.`created_at` AS `created_at`,
            `kredyty`.`updated_at` AS `updated_at`,
            (SELECT
                    COUNT(0)
                FROM
                    `raty`
                WHERE
                    `raty`.`status` = 'OPŁACONA'
                        AND `raty`.`id_kredytu` = `kredyty`.`id_kredytu`) AS `ilosc_oplaconych`,
            (SELECT
                    COUNT(0)
                FROM
                    `raty`
                WHERE
                    `raty`.`status` = 'NIEOPŁACONA'
                        AND `raty`.`id_kredytu` = `kredyty`.`id_kredytu`) AS `ilosc_nieoplaconych`,
            CASE
                WHEN
                    (SELECT
                            COUNT(0)
                        FROM
                            `raty`
                        WHERE
                            `raty`.`status` = 'NIEOPŁACONA'
                                AND `raty`.`id_kredytu` = `kredyty`.`id_kredytu`) > 1
                THEN
                    'W TOKU'
                ELSE 'OPŁACONY'
            END AS `status_kredytu`
        FROM
            `kredyty`
        WHERE
            `kredyty`.`zgoda_odmowa` = 'ZGODA'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
