<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnVitualAltKeyCodeAndVitualAltKeyNameToVpbankTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vpbank_transactions', function (Blueprint $table) {
            $table->string('vitualAltKeyCode', 50)->nullable()->comment('vitual alt key code');
            $table->string('vitualAltKeyName', 50)->nullable()->comment('vitual alt key name');
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
            $table->dropColumn('vitualAltKeyCode');
            $table->dropColumn('vitualAltKeyName');
        });
    }
}
