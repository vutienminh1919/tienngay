<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction', function (Blueprint $table) {
            $table->decimal('interest_early', 50, 15)->nullable()->comment('lai tra khi dao truoc han');
            $table->decimal('interest_paid', 50, 15)->nullable()->comment('lai da tra truoc khi dao truoc han');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction', function (Blueprint $table) {
            $table->dropColumn('interest_early');
            $table->dropColumn('interest_paid');
        });
    }
}
