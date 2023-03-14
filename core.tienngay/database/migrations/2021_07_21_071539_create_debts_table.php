<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("contract_id");
            $table->string("current_day");
            $table->string("ngay_ky_tra");
            $table->integer("so_ngay_cham_tra");
            $table->string("tong_tien_phai_tra");
            $table->string("tong_tien_goc_con");
            $table->string("tong_tien_phi_con");
            $table->string("tong_tien_lai_con");
            $table->string("tong_tien_cham_tra_con");
            $table->string("tong_tien_da_thanh_toan");
            $table->string("tong_tien_da_thanh_toan_pt");
            $table->string("ky_tt_xa_nhat");
            $table->string("ky_tt_xa_nhi");
            $table->integer("check_gia_han");
            $table->integer("check_tt_gh");
            $table->integer("check_tt_cc");
            $table->integer("thoi_han_vay");
            $table->datetime("run_date");
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
        Schema::dropIfExists('debts');
    }
}
