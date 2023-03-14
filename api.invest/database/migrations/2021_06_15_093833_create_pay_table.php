<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay', function (Blueprint $table) {
            $table->id();
            $table->string('code_contract');
            $table->string('investor_code');
            $table->float('interest', 8, 5);
            $table->string('type');
            $table->integer('ky_tra');
            $table->bigInteger('ngay_ky_tra');
            $table->integer('status');
            $table->unsignedBigInteger('contract_id');
            $table->string('created_by')->nullable();
            $table->float('goc_lai_1ky', 50, 15);
            $table->float('tien_goc_1ky', 50, 15);
            $table->float('tien_goc_con', 50, 15);
            $table->float('lai_ky', 50, 15);
            $table->float('tien_goc_1ky_phai_tra', 50, 15);
            $table->float('tien_lai_1ky_phai_tra', 50, 15);
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
        Schema::dropIfExists('pay');
    }
}
