<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTransakcjeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('transakcje', function (Blueprint $table) {
            $table->id();
            $table->string('nr_rachunku');
            $table->string('typ');
            $table->float('saldo_po_transakcji');
            $table->float('kwota');
            $table->dateTime('data_zlecenia');
            $table->dateTime('data_wykonania');
            $table->string('nr_rachunku_powiazanego')->nullable();
            $table->string('tytul')->nullable();
            $table->string('odbiorca')->nullable();
        });

        Schema::table('transakcje', function (Blueprint $table) {
            $table->foreign('nr_rachunku')->references('nr_rachunku')->on('rachunki');
            $table->foreign('nr_rachunku_powiazanego')->references('nr_rachunku')->on('rachunki');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('klienci');
    }
}
