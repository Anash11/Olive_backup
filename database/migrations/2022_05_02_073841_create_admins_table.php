<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('phone_no')->nullable(false);
            $table->dateTime('phone_no_verified_at')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=inactive,1=active');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address_info')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('code')->nullable();
            $table->enum('admin_type', ['super-admin', 'admin'])->default('admin');
            $table->string('adhar_no')->nullable();
            $table->string('area_of_operation')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('admins');
    }
}
