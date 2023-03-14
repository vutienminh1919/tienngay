<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestorInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investor_info', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->integer("type_investors");
            $table->string("merchant_id");
            $table->string("merchant_password");
            $table->string("receiver_email");
            $table->string("name");
            $table->string("dentity_card")->nullable();
            $table->date("date_of_birth")->nullable();
            $table->string("phone")->nullable();
            $table->string("email")->nullable();
            $table->string("address")->nullable();
            $table->string("tax_code")->nullable();
            $table->string("balance")->nullable();
            $table->string("percent_interest_investor")->nullable();
            $table->tinyInteger("form_of_receipt")->default(1); // 1: cash; 2: bank
            $table->string("account_number")->nullable();
            $table->integer("period")->nullable();
            $table->string("bank")->nullable();
            $table->string("bank_branch")->nullable();
            $table->tinyInteger("status")->default(1);
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
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
        Schema::dropIfExists('investor_info');
    }
}
