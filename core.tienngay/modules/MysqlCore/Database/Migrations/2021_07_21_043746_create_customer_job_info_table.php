<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerJobInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_job_info', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("customer_id");
            $table->string("company_name");
            $table->string("company_address");
            $table->string("company_phone_number");
            $table->string("job_position");
            $table->string("work_year");
            $table->string("salary");
            $table->tinyInteger("receive_salary_via")->default(1); // 1: cash; 2: bank
            $table->string("job_name");
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
        Schema::dropIfExists('customer_job_info');
    }
}
