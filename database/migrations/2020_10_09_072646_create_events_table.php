<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_event_id');
            $table->string('nameEvent');
            $table->string('organizer',50);
            $table->string('description');
            $table->dateTime('date');
            $table->string('place');
            $table->timestamps();

            $table->foreign('type_event_id')
            ->references('id')
            ->on('type_events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
