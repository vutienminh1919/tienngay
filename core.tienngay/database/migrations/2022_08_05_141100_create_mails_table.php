<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->id();
            $table->string('from', 50)->comment('from email');
            $table->string('to', 50)->comment('to email');
            $table->string('subject', 50)->comment('subject email');
            $table->text('message')->comment('message email');
            $table->text('errors')->nullable()->comment('message email');
            $table->string('nameFrom', 50)->comment('name from');
            $table->tinyInteger('type')->comment('Type of email');
            $table->tinyInteger('status')->comment('status of email');
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
        Schema::dropIfExists('mails');
    }
}
