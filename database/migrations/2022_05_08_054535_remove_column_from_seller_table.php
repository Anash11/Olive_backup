<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnFromSellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {

            $table->text('document_img_url')->after('phone_verified')->nullable();
            $table->string('business_name')->after('FK_category_id');
            $table->string('business_email')->after('business_name');
            $table->string('business_phone')->after('business_email');
            $table->dropColumn('seller_phone');
            $table->dropColumn('license_verified');
            $table->dropColumn('license_info');
            $table->dropColumn('user_type');
            $table->dropColumn('seller_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->string('user_type')->nullable();
            $table->json('license_info')->nullable();
            $table->boolean('license_verified')->default(false);
            $table->string('seller_email');
            $table->string('seller_phone');
            $table->dropColumn('business_name');
            $table->dropColumn('document_img_url');
            $table->dropColumn('business_email');
            $table->dropColumn('business_phone');
        });
    }
}
