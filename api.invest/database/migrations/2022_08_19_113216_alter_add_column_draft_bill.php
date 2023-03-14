<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnDraftBill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('draft_nl', function (Blueprint $table) {
            $table->string('bank_code_nl')->nullable();
            $table->json('bank_transfer_online')->nullable();
            $table->longText('token_bank_transfer_nl')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('draft_nl', function (Blueprint $table) {
            //
        });
    }
}
