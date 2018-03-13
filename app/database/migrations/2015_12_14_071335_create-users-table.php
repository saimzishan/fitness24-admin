<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');

            $table->string('first_name', 255);
            $table->string('last_name', 255)->nullable();
            $table->string('facebook_id', 255)->nullable();
            $table->string('email', 255);
            $table->string('password', 255);
            $table->string('profile_image', 255)->nullable();
            $table->string('phone_number', 255)->nullable();
            $table->string('zipcode', 255)->nullable();
            $table->enum('role', array('super_admin', 'user'))->default("user");
            $table->string('verification_code', 255)->nullable();
            $table->string('customer_id', 255)->nullable();
            $table->string('merchant_id', 255)->nullable();
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_login')->default(1);
            $table->boolean('archive')->default(0);
            $table->string('remember_token', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('users');
    }

}
