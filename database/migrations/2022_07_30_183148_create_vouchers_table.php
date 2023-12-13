<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('FK_seller_id');
            $table->string('title')->nullable();
            $table->text('terms')->nullable();
            $table->text('description')->nullable();
            $table->decimal('from_amount')->nullable();
            $table->decimal('to_amount')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('create_by')->nullable();
            $table->foreign('FK_seller_id')->references('id')->on('sellers')->onDelete('cascade');
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
        Schema::dropIfExists('vouchers');
    }
}
