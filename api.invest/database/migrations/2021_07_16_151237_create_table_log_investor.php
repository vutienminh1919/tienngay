<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLogInvestor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('log_investor', function (Blueprint $table) {
            $table->id();
            $table->json('request')->nullable();
            $table->json('response')->nullable();
            $table->string('url')->nullable();


            $table->string('type')->nullable();

            $table->string('created_by');
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
        Schema::dropIfExists('log_investor');
    }
}
