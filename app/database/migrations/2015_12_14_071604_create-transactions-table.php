<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('transactions', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('host_id')->unsigned();
            $table->foreign('host_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('parking_id')->unsigned();
//            $table->foreign('parking_id')->references('id')->on('parkings')->onDelete('cascade');
            $table->string('transaction_id', 255);
            $table->string('card_type', 255);
            $table->string('token', 255);
            $table->string('amount', 255);
            $table->string('status', 255);
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
        Schema::drop('transactions');
    }

}
