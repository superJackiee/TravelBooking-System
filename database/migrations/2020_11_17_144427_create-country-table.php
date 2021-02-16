<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('country')) {
            Schema::create('country', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title');
                $table->string('code');
                $table->string('phone_code');
                $table->integer('region_id');
                $table->string('flag_path');
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
        Schema::dropIfExists('country');
    }
}
