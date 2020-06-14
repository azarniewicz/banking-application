<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raty', function (Blueprint $table) {
            $table->id('id_raty');
            $table->float('cena');
            $table->string('status');
            $table->date('termin_zaplaty');
            $table->unsignedBigInteger('id_transakcji')->references('id_transakcji')->on('transakcje');
            $table->unsignedBigInteger('id_kredytu')->references('id_kredytu')->on('kredyty');
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
        Schema::dropIfExists('raty');
    }
}
