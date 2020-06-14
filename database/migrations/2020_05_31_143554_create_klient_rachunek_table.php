<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlientRachunekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klient_rachunek', function (Blueprint $table) {
            $table->uuid('id_rachunku')->references('id')->on('rachunki');
            $table->unsignedBigInteger('id_uzytkownika')->references('id')->on('uzytkownicy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('klient_rachunek');
    }
}
