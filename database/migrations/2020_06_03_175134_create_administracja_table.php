<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministracjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administracja', function (Blueprint $table) {
            $table->increments('id_admin');
            $table->string('email');
            $table->string('password');
            $table->string('pin',4);
            $table->string('imie');
            $table->string('nazwisko');
            $table->string('stanowisko');
            $table->string('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administracja');
    }
}
