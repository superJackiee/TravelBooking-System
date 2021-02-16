<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('enquiry')) {
            Schema::create('enquiry', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title');
                $table->string('reference_number');
                $table->integer('created_id');
                $table->integer('updated_id')->nullable();
                $table->integer('account_id');
                $table->integer('travel_number')->nullable();
                $table->integer('budget');
                $table->date('from_date')->nullable();
                $table->date('to_date')->nullable();
                $table->integer('adult_number');
                $table->integer('children_number');
                $table->integer('infant_number');
                $table->integer('single_count');
                $table->integer('double_count');
                $table->integer('twin_count');
                $table->integer('triple_count');
                $table->integer('family_count');
                $table->integer('is_assigned');
                $table->integer('assigned_user')->nullable();
                $table->integer('budget_per_total');
                $table->integer('is_created_itinerary');
                $table->longText('note')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('enquiry');
    }
}
