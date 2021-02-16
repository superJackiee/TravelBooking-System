<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarginItineraryDaily extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itinerary_daily', function (Blueprint $table) {
            $table->integer('itinerary_margin_price')->after('itinerary_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('itinerary_daily', function (Blueprint $table) {
            $table->dropColumn('itinerary_margin_price');
        });
    }
}
