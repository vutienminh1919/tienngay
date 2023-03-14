<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPayTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pay', function (Blueprint $table) {
            $table->bigInteger('interest_period')->nullable()->comment('ky_tra_lai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pay', function (Blueprint $table) {
            $table->dropColumn('interest_period');
        });
    }
}
