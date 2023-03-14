<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogChangeLeadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_change_lead', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->json('request')->nullable();
            $table->json('response')->nullable();
            $table->unsignedBigInteger('lead_investor_id')->nullable();
            $table->unsignedBigInteger('investor_id')->nullable();
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
        Schema::dropIfExists('log_change_lead');
    }
}
