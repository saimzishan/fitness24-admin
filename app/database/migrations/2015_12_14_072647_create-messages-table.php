<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('messages', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('msg_sender_id')->unsigned();
            $table->foreign('msg_sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('msg_receiver_id')->unsigned();
            $table->foreign('msg_receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('message', 255);
            $table->boolean('read_status')->default(0);
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
        Schema::drop('messages');
    }

}
