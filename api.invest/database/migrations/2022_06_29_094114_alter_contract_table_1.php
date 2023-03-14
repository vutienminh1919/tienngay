<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterContractTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract', function (Blueprint $table) {
            $table->integer('investment_cycle')->comment('chu kì đầu tư áp dụng với ndt ủy quyền')->nullable();
            $table->integer('interest_cycle')->comment('chu kì tính lãi áp dụng với ndt ủy quyền')->nullable();
            $table->integer('monthly_interest_payment_date')->comment('ngày trả lãi hàng tháng áp dụng với ndt ủy quyền')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract', function (Blueprint $table) {
            $table->dropColumn('investment_cycle');
            $table->dropColumn('interest_cycle');
            $table->dropColumn('monthly_interest_payment_date');
        });
    }
}
