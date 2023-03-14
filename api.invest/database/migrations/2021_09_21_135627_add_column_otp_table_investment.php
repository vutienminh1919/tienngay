<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOtpTableInvestment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investment', function (Blueprint $table) {
            $table->integer('otp_invest')->nullable();
            $table->timestamp('time_otp_invest')->nullable();
            $table->unsignedBigInteger('investor_create_otp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investment', function (Blueprint $table) {
            $table->dropColumn('otp_invest');
            $table->dropColumn('time_otp_invest');
            $table->dropColumn('investor_create_otp');
        });
    }
}
