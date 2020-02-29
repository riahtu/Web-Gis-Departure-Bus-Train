<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type',['bus','train']);
            $table->integer('line');
            $table->bigInteger('from_place_id')->unsigned();
            $table->bigInteger('to_place_id')->unsigned();
            $table->string('departure_time',100);
            $table->string('arrival_time',100);
            $table->string('distance',20);
            $table->string('speed',20);
            $table->timestamps();

            $table->foreign('from_place_id')->references('id')->on('places');
            $table->foreign('to_place_id')->references('id')->on('places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
