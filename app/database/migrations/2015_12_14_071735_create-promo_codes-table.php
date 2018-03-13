<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoCodesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('promo_codes', function(Blueprint $table) {
            $table->increments('id');

            $table->string('coupon', 255);
            $table->string('amount', 255);
            $table->integer('per_user');
            $table->integer('per_coupon');
            $table->string('valid_from', 255);
            $table->string('valid_to', 255);
            $table->string('status', 255);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('promo_codes');
    }

}
