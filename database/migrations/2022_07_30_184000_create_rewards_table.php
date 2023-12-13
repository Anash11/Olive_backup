<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('FK_user_id')->unsigned();
            $table->bigInteger('FK_seller_id')->unsigned();
            $table->bigInteger('FK_voucher_id')->unsigned();
            $table->enum('is_scratched', ['Yes', 'No'])->default('No');
            $table->foreign('FK_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('FK_seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->foreign('FK_voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rewards');
    }
}
