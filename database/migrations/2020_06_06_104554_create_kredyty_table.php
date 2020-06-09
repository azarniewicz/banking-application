<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKredytyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kredyty', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kredytu')->autoIncrement();
            $table->unsignedBigInteger('id_klienta');
            $table->dateTime('data_wniosku');
            $table->dateTime('data_zakonczenia_wniosku')->nullable();
            $table->float('kwota_kredytu');
            $table->float('oprocentowanie');
            $table->string('zgoda_odmowa')->nullable();

            $table->tinyInteger('ilosc_rat');
            $table->timestamps();
        });

        Schema::table('kredyty', function (Blueprint $table) {
            $table->foreign('id_klienta')->references('id')->on('klienci')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kredyty');
    }
}
