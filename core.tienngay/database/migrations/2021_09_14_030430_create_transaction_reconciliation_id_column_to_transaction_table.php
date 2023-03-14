<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionReconciliationIdColumnToTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('epayment_transactions', function (Blueprint $table) {
            $table->foreignId('transaction_reconciliation_id')->nullable()->comment('transaction_reconciliation table');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('epayment_transactions', function (Blueprint $table) {
            $table->dropColumn('transaction_reconciliation_id');
        });
    }
}
