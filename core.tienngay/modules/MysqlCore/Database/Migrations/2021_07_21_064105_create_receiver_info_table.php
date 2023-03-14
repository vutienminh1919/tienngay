<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiverInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receiver_info', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("loan_id");
            $table->tinyInteger("payout_type");
            $table->integer("bank_id");
            $table->string("bank_name");
            $table->string("bank_branch");
            $table->string("bank_account");
            $table->string("bank_account_holder");
            $table->string("atm_card_number");
            $table->string("atm_card_holder");
            $table->integer("store_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receiver_info');
    }
}
