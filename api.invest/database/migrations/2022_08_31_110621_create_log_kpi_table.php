<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogKpiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_kpi', function (Blueprint $table) {
            $table->id();
            $table->string('id_kpi')->nullable();
            $table->string('action')->nullable();
            $table->string('type')->nullable();
            $table->json('old')->nullable();
            $table->json('new')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('log_kpi');
    }
}
