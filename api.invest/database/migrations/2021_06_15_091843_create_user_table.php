<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('full_name');
            $table->string('status');
            $table->integer('type')->comment('Phân loại user');
            $table->string('channels')->nullable();
            $table->string('avatar')->nullable();
            $table->string('token_active')->nullable();
            $table->string('timeExpried_active')->nullable();
            $table->string('investor_reviews')->nullable();
            $table->longText('token_web')->nullable();
            $table->longText('token_app')->nullable();
            $table->string('card_back')->nullable();
            $table->string('front_facing_card')->nullable();
            $table->string('identity')->nullable();
            $table->string('created_by')->nullable();
            $table->string('token_reset_password')->nullable();
            $table->string('time_token_exprired_reset_password')->nullable();
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
        Schema::dropIfExists('user');
    }
}
