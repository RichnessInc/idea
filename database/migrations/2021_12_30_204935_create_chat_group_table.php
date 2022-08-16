<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id');
            $table->foreign('buyer_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('provieder_id');
            $table->foreign('provieder_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('sender_id')->nullable();
            $table->foreign('sender_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('request_id');
            $table->foreign('request_id')->references('id')->on('product_requests')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('chat_group');
    }
}
