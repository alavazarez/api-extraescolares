<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acoms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('typeAcom_id');
            $table->string('no_de_control');
            $table->dateTime('dateDelivery')->nullable();
            $table->string('description');
            $table->integer('status');
            $table->softDeletes(); //línea, para el borrado lógico
            $table->timestamps();

            $table->foreign('typeAcom_id')
            ->references('id')
            ->on('type_acoms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acoms');
    }
}
