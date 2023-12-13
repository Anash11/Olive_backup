<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers_templates', function (Blueprint $table) {
            $table->id();
            $table->string('offer_code')->unique();
            $table->string('offer_title');
            $table->string('offer_template');
            $table->json('offer_type');
            $table->integer('var_count');
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
        Schema::dropIfExists('offers_templates');
    }
}
