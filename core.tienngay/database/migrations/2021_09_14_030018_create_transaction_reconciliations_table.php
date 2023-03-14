<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionReconciliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_reconciliations', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8);
            $table->decimal('pay_amount', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->timestamp('paid_date', 0)->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: payment pending, 2: payment success, 3: underpayment');
            $table->string('created_by', 100);
            $table->string('updated_by', 100);
            $table->softDeletes();
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
        Schema::dropIfExists('transaction_reconciliations');
    }
}
