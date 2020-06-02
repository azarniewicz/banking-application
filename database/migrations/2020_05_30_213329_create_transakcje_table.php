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
            $table->uuid('id_rachunku')->index();
            $table->string('typ');
            $table->float('saldo_po_transakcji');
            $table->float('kwota');
            $table->dateTime('data');
            $table->uuid('id_rachunku_powiazanego')->nullable();
            $table->string('tytul')->nullable();
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
