<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVpbankVansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpbank_vans', function (Blueprint $table) {
            $table->id();
            $table->string('virtualAccNo', 20)->unique()->comment('virtual account number');
            $table->string('virtualAccName', 70)->nullable()->comment('vitaul account name');
            $table->string('virtualMobile', 12)->nullable()->comment('mobile');
            $table->string('virtualGroup', 50)->nullable()->comment('group');
            $table->string('virtualAltKey', 35)->nullable()->comment('altkey');
            $table->string('storeCode', 35)->nullable()->comment('store collection vpb_store_code');
            $table->string('openDate', 12)->comment('active date');
            $table->string('valueDate', 12)->comment('active date');
            $table->string('expiryDate', 12)->comment('inactive date');
            $table->string('mainCustomerNo', 50)->comment('Master customer number');
            $table->string('mainAcctNo', 50)->comment('Master account number');
            $table->string('company_name', 50)->comment('VFC or VFCDB');
            $table->string('customer_id', 25)->nullable()->comment('customer table id');
            $table->string('status', 10)->comment('active or inactive');
            $table->softDeletes('deleted_at', 0)->comment('soft delete');
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
        Schema::dropIfExists('vpbank_vans');
    }
}
