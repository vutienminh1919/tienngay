<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogConfigCallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_config_call', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->json('request')->nullable();
            $table->json('response')->nullable();
            $table->string('created_by')->nullable();
            $table->unsignedBigInteger('config_call_id')->nullable();
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
        Schema::dropIfExists('log_config_call');
    }
}
