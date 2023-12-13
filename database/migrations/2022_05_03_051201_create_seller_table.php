<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('FK_user_id');
            $table->foreign('FK_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('FK_category_id');
            $table->foreign('FK_category_id')->references('id')->on('category');
            $table->string('seller_email');
            $table->boolean('email_verified')->default(false);
            $table->string('seller_phone')->nullable();
            $table->boolean('phone_verified')->default(false);
            $table->enum('status',['Active', 'Inactive'])->default('Inactive');
            $table->boolean('verified')->default(false);
            $table->string('user_type')->nullable();
            $table->json('license_info')->nullable();
            $table->boolean('license_verified')->default(false);
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
        Schema::dropIfExists('seller');
    }
}
