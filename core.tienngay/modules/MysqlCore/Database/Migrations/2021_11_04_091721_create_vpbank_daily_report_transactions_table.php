<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVpbankDailyReportTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpbank_daily_report_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('filename', 100)->nullable()->comment('Tên file lấy dữ liệu');
            $table->string('virtualAccountNumber', 50)->nullable()->comment('Mã tài khoản VAN');
            $table->decimal('amount', 15, 2)->nullable()->comment('Số tiền đã thu');
            $table->string('remark', 255)->nullable()->comment('Nội dung chuyển tiền');
            $table->string('transactionId', 50)->nullable()->comment('Mã giao dịch tại VPB');
            $table->string('transactionDate', 25)->nullable()->comment('Thời gian thực hiện giao dịch. Định dạng yyyy-MM-dd HH:mm:ss');
            $table->string('bookingDate', 25)->nullable()->comment('Thời gian ghi nhận giao dịch định dạng yyyy-MM-dd');
            $table->string('notification', 500)->nullable()->comment('Tình trạng gọi notification');
            $table->tinyInteger('status')->comment('Trạng thái đối soát');
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
        Schema::dropIfExists('vpbank_daily_report_transactions');
    }
}
