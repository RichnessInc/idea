<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat', function (Blueprint $table) {
            $table->id();

            $table->foreignId('send_from_client')->nullable();
            $table->foreign('send_from_client')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('send_from_admin');
            $table->foreign('send_from_admin')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->longText('message');

            $table->string('file')->nullable();


            $table->boolean('readed')->default(0);

            $table->foreignId('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('chat');
    }
}
