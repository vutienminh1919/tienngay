<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributeScanDateIntoLeadInvestorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_investor', function (Blueprint $table) {
             $table->bigInteger('scan_date')->nullable();
             $table->integer('day_call')->nullable();
             $table->integer('state')->nullable();
             $table->integer('call_id')->nullable();
             $table->integer('vbee_call')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lead_investor', function (Blueprint $table) {
            $table->dropColumn('scan_date');
            $table->dropColumn('day_call');
            $table->dropColumn('state');
            $table->dropColumn('call_id');
            $table->dropColumn('vbee_call');
        });
    }
}
