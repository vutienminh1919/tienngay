<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLogNlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_nl', function (Blueprint $table) {
            $table->id();
            $table->json('request')->nullable();
            $table->json('response')->nullable();
            $table->string('type')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
            $table->string('flow')->nullable();
            $table->unsignedBigInteger('draft_nl_id')->nullable();
            $table->unsignedBigInteger('pay_id')->nullable();
            $table->string('order_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_nl');
    }
}
