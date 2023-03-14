<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investor', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('identity')->nullable()->unique();
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->string('status');
            $table->string('phone_vimo')->nullable();
            $table->string('linked_id_vimo')->nullable();
            $table->string('token_id_vimo')->nullable();
            $table->string('created_by')->nullable();
            $table->string('avatar')->nullable();
            $table->string('token_active')->nullable();
            $table->string('timeExpried_active')->nullable();
            $table->string('investor_reviews')->nullable();
            $table->string('card_back')->nullable();
            $table->string('front_facing_card')->nullable();
            $table->timestamp('active_at')->nullable();
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('investor');
    }
}
