<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract', function (Blueprint $table) {
            $table->id();
            $table->string('code_contract');
            $table->string('code_contract_disbursement');
            $table->string('type_loan')->nullable();
            $table->string('type_property')->nullable();
            $table->string('name_property')->nullable();
            $table->bigInteger('amount_money');
            $table->bigInteger('amount_loan')->nullable();
            $table->string('number_day_loan');
            $table->bigInteger('investment_amount');
            $table->json('interest');
            $table->unsignedBigInteger('investor_id');
            $table->string('created_by');
            $table->string('investor_code');
            $table->string('note')->nullable();
            $table->unsignedBigInteger('interest_id')->nullable();
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
        Schema::dropIfExists('contract');
    }
}
