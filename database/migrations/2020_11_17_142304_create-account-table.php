<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('account')) {
            Schema::create('account', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('user_id');
                $table->string('first_name',100);
                $table->string('last_name',100);
                $table->integer('account_type');
                $table->string('website_url', 100)->nullable();
                $table->text('avatar_path')->nullable();
                $table->integer('status');
                $table->string('main_street_address', 100)->nullable();
                $table->integer('main_city')->nullable();
                $table->string('main_postal_code', 100)->nullable();
                $table->string('main_region_state', 100)->nullable();
                $table->integer('main_country')->nullable();
                $table->string('main_office_phone', 100)->nullable();
                $table->string('main_email', 100)->nullable();
                $table->string('billing_status', 100)->nullable();
                $table->string('billing_company_name', 100)->nullable();
                $table->string('billing_street_address', 100)->nullable();
                $table->integer('billing_city')->nullable();
                $table->string('billing_postal_code', 100)->nullable();
                $table->string('billing_state_region', 100)->nullable();
                $table->integer('billing_country')->nullable();
                $table->string('billing_office_phone', 100)->nullable();
                $table->string('billing_email', 100)->nullable();
                $table->longText('description')->nullable();
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
        Schema::dropIfExists('account');
    }
}
