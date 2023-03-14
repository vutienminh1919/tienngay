<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDiscountedFeeToEpaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('epayment_transactions', function (Blueprint $table) {
            $table->decimal('discounted_fee', 15, 2)->default(0)->comment('Phí miễn giảm');
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
            $table->dropColumn('discounted_fee');
        });
    }
}
