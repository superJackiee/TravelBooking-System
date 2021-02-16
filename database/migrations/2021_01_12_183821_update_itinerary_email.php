<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateItineraryEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itinerary', function (Blueprint $table) {
            $table->string('from_email')->after('enquiry_id');
            $table->string('to_email')->after('from_email');
            $table->string('attach_file')->after('to_email');
            $table->binary('email_template')->after('attach_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('itinerary', function (Blueprint $table) {
            $table->dropColumn('from_email');
            $table->dropColumn('to_email');
            $table->dropColumn('attach_file');
            $table->dropColumn('email_template');
        });
    }
}
