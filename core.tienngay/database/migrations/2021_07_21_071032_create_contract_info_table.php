<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_info', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("customer_id");
            $table->bigInteger("loan_id");
            $table->string("created_by");
            $table->string("code_contract");
            $table->string("number_contract");
            $table->integer("status");
            $table->string("note");
            $table->string("code_contract_disbursement");
            $table->string("disbursement_date");
            $table->integer("status_disbursement");
            $table->string("expire_date");
            $table->string("investor_code");
            $table->integer("status_run_fee_again");
            $table->string("total_debt_pay");
            $table->string("asset_code");
            $table->string("updated_by");
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
        Schema::dropIfExists('contract_info');
    }
}
