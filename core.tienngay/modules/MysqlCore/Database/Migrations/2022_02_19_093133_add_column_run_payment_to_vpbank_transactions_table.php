<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRunPaymentToVPBankTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vpbank_transactions', function (Blueprint $table) {
            $table->tinyInteger('run_payment')->comment('Trạng thái chạy thanh toán');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vpbank_transactions', function (Blueprint $table) {
            $table->dropColumn('run_payment');
        });
    }
}
