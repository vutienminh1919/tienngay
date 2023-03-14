<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('code_contract');
            $table->bigInteger('investment_amount');
            $table->string('investor_code');
            $table->unsignedBigInteger('contract_id');
            $table->string('transaction_vimo')->nullable();
            $table->integer('type_method')->nullable();
            $table->integer('status')->nullable();
            $table->json('interest')->nullable();
            $table->string('note')->nullable();
            $table->bigInteger('account_balance')->nullable();
            $table->decimal('tien_goc', 50, 15)->nullable();
            $table->decimal('tien_lai', 50, 15)->nullable();
            $table->decimal('tong_goc_lai', 50, 15)->nullable();
            $table->unsignedBigInteger('pay_id')->nullable();
            $table->string('created_by');
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
        Schema::dropIfExists('transaction');
    }
}
