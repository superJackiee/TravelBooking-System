<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product')) {
            Schema::create('product', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title');
                $table->integer('category');
                $table->integer('country');
                $table->integer('city');
                $table->string('location');
                $table->string('start_time');
                $table->string('end_time');
                $table->integer('supplier');
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
        Schema::dropIfExists('product');
    }
}
