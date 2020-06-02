<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRachunkiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rachunki', function (Blueprint $table) {
            $table->uuid('id')->index();
            $table->string('nr_rachunku')->unique();
            $table->double('saldo')->default(0);
            $table->string('typ')->nullable()->default('standard');
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
        Schema::dropIfExists('rachunki');
    }
}
