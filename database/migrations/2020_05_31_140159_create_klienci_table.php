<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlienciTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klienci', function (Blueprint $table) {
            $table->id();
            $table->integer('id_uzytkownika');
            $table->string('pesel');
            $table->string('miasto');
            $table->string('ulica_nr');
            $table->string('kod_pocztowy');
            $table->string('nr_telefonu');
            $table->string('nr_dowodu');
            $table->float('limit_dzienny');
            $table->float('ustawienie_budzetu');
            $table->timestamps();
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
