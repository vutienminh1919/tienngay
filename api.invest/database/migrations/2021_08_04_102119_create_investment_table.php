<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment', function (Blueprint $table) {
            $table->id();
            $table->string('code_contract')->nullable();
            $table->string('code_contract_disbursement')->nullable();
            $table->integer('number_day_loan')->nullable();
            $table->bigInteger('amount_money')->nullable();
            $table->string('type_interest')->nullable();
            $table->integer('type')->nullable();
            $table->string('contract_id')->nullable();
            $table->string('investor_confirm')->nullable();
            $table->unsignedBigInteger('number')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('investment');
    }
}
