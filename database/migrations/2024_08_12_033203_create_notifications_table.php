<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender_id');
            $table->string('channel_type');
            $table->bigInteger('message_id');
            $table->string('category');
            $table->integer('duration')->nullable();
            $table->integer('interval')->nullable();
            $table->dateTime('sent_at', null)->default(null);
            $table->tinyInteger('is_recurring')->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->tinyInteger('is_response')->nullable();
            $table->bigInteger('response_by')->nullable();
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
        Schema::dropIfExists('notifications');
    }
};
