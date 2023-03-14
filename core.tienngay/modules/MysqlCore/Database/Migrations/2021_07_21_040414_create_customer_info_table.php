<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_info', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger("customer_status")->default(1); // 1: new customer; 2: old customer
            $table->string("customer_name");
            $table->string("customer_email");
            $table->string("customer_phone_number");
            $table->string("customer_identify");
            $table->string("customer_identify_front_side");
            $table->string("customer_identify_back_side");
            $table->string("customer_identify_avatar_image");
            $table->date("customer_identify_date");
            $table->string("customer_identify_address");
            $table->string("old_customer_identify")->nullable();
            $table->string("passport_number")->nullable();
            $table->string("passport_address")->nullable();
            $table->date("passport_date")->nullable();
            $table->integer("customer_resources");
            $table->tinyInteger("customer_gender");
            $table->date("customer_BOD");
            $table->tinyInteger("marriage")->default(2); // 1: Da ket hon; 2: chua ket hon; 3: ly hon
            $table->string("current_province");
            $table->string("current_province_name");
            $table->string("current_district")->nullable();
            $table->string("current_district_name")->nullable();
            $table->string("current_ward")->nullable();
            $table->string("current_ward_name")->nullable();
            $table->string("current_stay")->nullable();
            $table->string("current_form_residence")->nullable();
            $table->string("current_time_life")->nullable();
            $table->string("house_hold_province");
            $table->string("house_hold_province_name");
            $table->string("house_hold_district");
            $table->string("house_hold_district_name");
            $table->string("house_hold_ward");
            $table->string("house_hold_ward_name");
            $table->string("house_hold_address");
            $table->string("customer_relationships");
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
        Schema::dropIfExists('customer_info');
    }
}
