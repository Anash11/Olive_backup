<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('FK_shop_id');
            $table->foreign('FK_shop_id')->references('shop_id')->on('sellers');
            $table->string('offer_type')->comment('(FLAT,Buy x get y,etc)');
            $table->string('offer_title')->nullable();
            $table->string('offer_description')->nullable();
            $table->string('offer_img_url')->nullable();
            $table->string('offer_start_date')->nullable();
            $table->string('offer_end_date')->nullable();
            $table->enum('offer_status',['Active', 'Inactive'])->default('Inactive');
            $table->string('create_by');
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
        Schema::dropIfExists('offers');
    }
}
