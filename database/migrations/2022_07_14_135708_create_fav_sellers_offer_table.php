<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavSellersOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fav_sellers_offer', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('FK_user_id')->unsigned();            
            $table->bigInteger('FK_offer_id')->unsigned();
            $table->string('message');
            $table->enum('is_seen',['unseen','seen'])->default('unseen');
            $table->foreign('FK_user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('fav_sellers_offer');
    }
}
