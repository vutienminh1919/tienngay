<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumTableInvestor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investor', function (Blueprint $table) {
            $table->date('birthday')->nullable();
            $table->string('city')->nullable();
            $table->integer('status_call')->nullable();
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
            $table->dropColumn('birthday');
            $table->dropColumn('city');
            $table->dropColumn('status_call');
        });
    }
}
