<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVpbankTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpbank_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('masterAccountNumber', 50)->nullable()->comment('Số tài khoản chuyên thu');
            $table->string('virtualAccountNumber', 50)->nullable()->comment('Mã tài khoản VAN');
            $table->string('virtualName', 50)->nullable()->comment('Tên tài khoản VAN');
            $table->decimal('amount', 15, 2)->comment('Số tiền đã thu');
            $table->string('remark', 255)->nullable()->comment('Nội dung chuyển tiền');
            $table->string('transactionId', 20)->comment('Mã giao dịch tại VPB');
            $table->timestamp('transactionDate', 0)->comment('Thời gian thực hiện giao dịch. Định dạng yyyy-MM-dd HH:mm:ss');
            $table->string('bookingDate', 25)->comment('Thời gian ghi nhận giao dịch định dạng yyyy-MM-dd');
            $table->tinyInteger('status')->comment('Trạng thái gạch nợ');
            $table->tinyInteger('tran_status')->comment('Trạng thái giao dịch');
            $table->string('contract_id', 100)->nullable();
            $table->string('contract_code', 50)->nullable();
            $table->string('contract_code_disbursement', 255)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('identity_card', 100)->nullable()->comment("customer identity card number");
            $table->string('store_id', 100)->nullable();
            $table->string('store_name', 150)->nullable();
            $table->string('store_address', 255)->nullable();
            $table->string('store_code_address', 100)->nullable();
            $table->string('tn_transactionId', 100)->nullable()->comment('transaction id which is stored in api.tienngay sever');
            $table->string('tn_trancode', 50)->nullable()->comment('TienNgay transaction code');
            $table->tinyInteger('daily_confirmed')->comment('Trạng thái đối soát hàng ngày');
            $table->tinyInteger('monthly_confirmed')->comment('Trạng thái đối soát hàng tháng');

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
        Schema::dropIfExists('vpbank_transactions');
    }
}
