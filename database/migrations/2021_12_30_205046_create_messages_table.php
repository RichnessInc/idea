<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->longText('message');
            $table->string('file')->nullable();
            $table->boolean('type')->default(0);

            $table->foreignId('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('group_id')->nullable();
            $table->foreign('group_id')->references('id')->on('chat_groups')->onUpdate('cascade')->onDelete('cascade');


            $table->boolean('user_readed')->default(0);
            $table->boolean('buyer_readed')->default(0);
            $table->boolean('providers_readed')->default(0);
            $table->boolean('sender_readed')->default(0);

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
        Schema::dropIfExists('messages');
    }
}
