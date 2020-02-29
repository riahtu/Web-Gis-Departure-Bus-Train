<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouteHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('from_place_id')->unsigned();
            $table->bigInteger('to_place_id')->unsigned();
            $table->string('schedule_id');
            $table->bigInteger('frekuensi');
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
        Schema::dropIfExists('route_historys');
    }
}

