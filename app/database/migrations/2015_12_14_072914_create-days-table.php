<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDaysTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('days', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('parking_id')->unsigned();
            $table->foreign('parking_id')->references('id')->on('parkings')->onDelete('cascade');
            $table->string('day', 255);
            $table->integer('sort');
            $table->integer('price_per_hour');
            $table->integer('max_price');
            $table->boolean('archive')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('days');
    }

}
