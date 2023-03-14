<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('client name');
            $table->string('email', 70)->nullable()->comment('client email');
            $table->string('phone', 12)->nullable()->comment('client phone number');
            $table->string('customer_identity', 25)->unique()->comment('cccd');
            $table->string('customer_identity_old', 25)->nullable()->comment('cmt');
            $table->string('passport', 20)->nullable()->comment('client passport number');
            $table->string('date_of_birth', 12)->nullable();
            $table->string('current_address')->nullable();
            $table->string('household_address')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
