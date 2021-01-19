<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnoEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Asistencias', function (Blueprint $table) {
            $table->id();
            $table->string('no_de_control');
            $table->unsignedBigInteger('event_id');
            $table->timestamps();
            
            $table->foreign('event_id')
            ->references('id')
            ->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Asistencias');
    }
}