<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpaymentTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epayment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('request_check_bill', 255);
            $table->string('request_notify_payment', 255)->nullable();
            $table->string('transactionId', 255)->nullable();
            $table->string('contract_id', 255)->nullable();
            $table->string('contract_code', 255)->nullable();
            $table->string('contract_code_disbursement', 255)->nullable();
            $table->string('contract_store_id', 255)->nullable();
            $table->string('contract_store_name', 255)->nullable();
            $table->string('contract_status', 255)->nullable();
            $table->string('contract_transaction_id', 255)->nullable()->comment('transaction id which is stored in api.tienngay sever');
            $table->decimal('transaction_fee', 15, 2)->nullable();
            $table->tinyInteger('epayment_code');
            $table->string('epayment_name', 255);
            $table->tinyInteger('payment_option');
            $table->tinyInteger('status')->default(1)->comment('1: payment pending, 2: payment success');
            $table->decimal('total_amount', 15, 2);
            $table->decimal('paid_amount', 15, 2)->nullable();
            $table->timestamp('paid_date', 0)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('mobile', 255)->nullable();
            $table->string('identity_card', 255)->nullable()->comment("customer identity card number");
            $table->decimal('debt_amount', 15, 2)->default(0)->comment('debt amount');
            $table->decimal('late_fee', 15, 2)->default(0)->comment('late_fee');
            $table->decimal('actual_unpaid_fee', 15, 2)->default(0)->comment('actual unpaid fee');
            $table->decimal('early_repayment_charge', 15, 2)->default(0)->comment('early repayment charge');
            $table->decimal('cost_incurred', 15, 2)->default(0)->comment('cost incurred');
            $table->decimal('unpaid_money', 15, 2)->default(0)->comment('unpaid money of the previous term');
            $table->decimal('balance_prev_term', 15, 2)->default(0)->comment('balance of previous term');
            $table->decimal('excess_payment', 15, 2)->default(0)->comment('excess payment amount');
            $table->decimal('next_payment_amount', 15, 2)->default(0)->comment('payment amount of the next term');
            $table->tinyInteger('confirmed')->default(1)->comment('1: default value, 2: transaction confirmed');
            $table->softDeletes('deleted_at', 0)->comment('soft delete');
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
        Schema::dropIfExists('epayment_transactions');
    }
}
