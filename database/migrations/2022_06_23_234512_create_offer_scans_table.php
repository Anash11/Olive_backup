<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferScansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_scans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('FK_user_id')->unsigned();
            $table->bigInteger('FK_seller_id')->unsigned();
            $table->bigInteger('FK_offer_id')->unsigned();
            $table->enum('status', ['Accepted', 'Decline'])->default('Accepted');
            $table->foreign('FK_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('FK_seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->foreign('FK_offer_id')->references('id')->on('offers')->onDelete('cascade');
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
        Schema::dropIfExists('offer_scans');
    }
}
