<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInvestorTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investor', function (Blueprint $table) {
            $table->string('interest_receiving_account')->nullable();
            $table->string('type_interest_receiving_account')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('name_bank_account')->nullable();
            $table->integer('type_card')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investor', function (Blueprint $table) {
            $table->dropColumn('interest_receiving_account');
            $table->dropColumn('type_interest_receiving_account');
            $table->dropColumn('bank_name');
            $table->dropColumn('name_bank_account');
            $table->dropColumn('type_card');
        });
    }
}
