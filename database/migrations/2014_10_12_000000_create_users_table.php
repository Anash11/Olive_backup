<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('phone')->unique();
            $table->string('otp');
            $table->dateTime('phone_no_verified_at')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=inactive,1=active');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->json('address_info')->nullable();
            $table->date('dob')->nullable();
            $table->enum('code', ['seller', 'user'])->default('user');
            $table->text('profile_photo_path')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
