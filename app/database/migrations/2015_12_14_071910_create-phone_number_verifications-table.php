<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneNumberVerificationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('phone_number_verifications', function(Blueprint $table) {
            $table->increments('id');

            $table->string('phone_number', 255);
            $table->string('verification_code', 255);
            $table->boolean('status')->default(1);
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
        Schema::drop('phone_number_verifications');
    }

}
