<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParkingFeaturesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('parking_features', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('parking_id')->unsigned();
//            $table->foreign('parking_id')->references('id')->on('parkings')->onDelete('cascade');
            $table->integer('feature_id')->unsigned();
//            $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');
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
        Schema::drop('parking_features');
    }

}
