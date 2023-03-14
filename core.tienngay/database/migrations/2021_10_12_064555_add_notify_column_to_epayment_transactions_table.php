<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotifyColumnToEpaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('epayment_transactions', function (Blueprint $table) {
            $table->string('notifyUrl', 255)->nullable()->comment('appNDT payment notify url');
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
            $table->dropColumn('notifyUrl');
        });
    }
}
