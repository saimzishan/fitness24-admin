<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParkingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('parkings', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('address', 255);
            $table->integer('spot_number');
            $table->string('city', 255);
            $table->string('state', 255);
            $table->string('country', 255);
            $table->integer('zipcode');
            $table->decimal('lat',10,8);
            $table->decimal('lng',10,8);
            $table->text('description');
            $table->boolean('is_reserved')->default(0);
            $table->boolean('archive')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('parkings');
    }

}
