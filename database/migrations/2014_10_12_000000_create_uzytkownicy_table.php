<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUzytkownicyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzytkownicy', function (Blueprint $table) {
            $table->id();
            $table->string('imie',100);
            $table->string('nazwisko',100);
            $table->string('pin',20);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',200);
            $table->string('typ',100);
            $table->tinyInteger('is_zablokowana')->default(0);
            $table->tinyInteger('is_reset_pin')->default(0);
            $table->tinyInteger('is_reset_password');

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
        Schema::dropIfExists('uzytkownicy');
    }
}
