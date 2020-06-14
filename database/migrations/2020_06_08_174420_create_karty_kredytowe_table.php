<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKartyKredytoweTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karty_kredytowe', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_rachunku')->references('id')->on('rachunki');
            $table->string('nr_karty');
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
        Schema::dropIfExists('karty_kredytowe');
    }
}
