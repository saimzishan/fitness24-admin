<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('times', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('day_id')->unsigned();
//            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
            $table->time('start_time');
            $table->time('end_time');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('times');
    }

}
