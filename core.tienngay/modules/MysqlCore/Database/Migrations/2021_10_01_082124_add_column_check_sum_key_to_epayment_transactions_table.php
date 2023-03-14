<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCheckSumKeyToEpaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('epayment_transactions', function (Blueprint $table) {
            $table->string('checkSumKey', 50)->nullable()->comment('checksum key');
            $table->tinyInteger('client_code')->nullable()->comment('null: momo app, 1: android appkh, 2: ios appkh, 3: web');
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
            $table->dropColumn('checkSumKey');
            $table->dropColumn('client_code');
        });
    }
}
