<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoredEventsTable extends Migration
{
    public function up()
    {
        Schema::create('stored_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('aggregate_uuid')->references('id')->on('rachunki');
            $table->unsignedBigInteger('aggregate_version')->nullable();
            $table->string('event_class');
            $table->string('event_properties');
            $table->string('meta_data');
            $table->timestamp('created_at');
            $table->index('event_class');
            $table->index('aggregate_uuid');
        });
    }
}
