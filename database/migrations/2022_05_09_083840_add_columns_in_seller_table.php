<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInSellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->string('shop_logo_url')->nullable();
            $table->string('shop_id')->unique();
            $table->string('shop_name')->nullable();
            $table->string('area')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('shop_contact')->nullable();
            $table->json('shop_media')->comment('[{type:’video’, url:’http://abc.com/’}.....]')->nullable();
            $table->json('weekly_timing')->comment('Ex - {monday:{is_open:true, open:’10AM’,close:’8PM’}..}')->nullable();
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
            $table->dropColumn('shop_logo_url');
            $table->dropColumn('shop_id');
            $table->dropColumn('shop_name');
            $table->dropColumn('area');
            $table->dropColumn('zip');
            $table->dropColumn('city');
            $table->dropColumn('address');
            $table->dropColumn('shop_contact');
            $table->dropColumn('shop_media');
            $table->dropColumn('weekly_timing');
        });
    }
}
