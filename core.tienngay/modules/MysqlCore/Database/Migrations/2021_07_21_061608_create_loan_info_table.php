<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_info', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("customer_id");
            $table->integer("loan_type");
            $table->integer("property_type");
            $table->tinyInteger("loan_product");
            $table->string("link_shop");
            $table->integer("property_name");
            $table->string("property_price");
            $table->string("amount_money");
            $table->string("max_money_amount");
            $table->tinyInteger("loan_purpose");
            $table->tinyInteger("interest_type");
            $table->tinyInteger("number_day_loan");
            $table->tinyInteger("fee_type");
            $table->tinyInteger("insurrance");
            $table->tinyInteger("loan_insurrance");
            $table->string("gic_fee");
            $table->tinyInteger("gic_easy_type");
            $table->string("gic_easy_fee");
            $table->tinyInteger("gic_vbi_type");
            $table->string("gic_vbi_fee");
            $table->tinyInteger("gic_plt_type");
            $table->tinyInteger("is_free_gic_plt");
            $table->string("gic_plt_fee");
            $table->tinyInteger("gic_tnds_type");
            $table->string("gic_tnds_fee");
            $table->tinyInteger("coupon_type");
            $table->string("coupon_note");
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
        Schema::dropIfExists('loan_info');
    }
}
