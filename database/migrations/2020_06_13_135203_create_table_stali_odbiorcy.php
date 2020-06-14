<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStaliOdbiorcy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stali_odbiorcy', function (Blueprint $table) {
            $table->integer('id_odbiorcy')->autoIncrement();
            $table->string('nazwa');
            $table->string('nr_rachunku');
            $table->string('nazwa_adres');
            $table->integer('id_klienta')->references('id')->on('klienci');
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
        Schema::dropIfExists('stali_odbiorcy');
    }
}
