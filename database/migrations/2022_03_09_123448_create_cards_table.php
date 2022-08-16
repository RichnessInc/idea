<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('sound')->nullable();
            $table->string('image')->nullable();
            $table->string('slug')->nullable();
            $table->text('text')->nullable();

            $table->string('from')->nullable();
            $table->string('to')->nullable();


            $table->foreignId('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('sound_id')->nullable();
            $table->foreign('sound_id')->references('id')->on('cards_sounds')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('background_id')->nullable();
            $table->foreign('background_id')->references('id')->on('cards_backgrounds')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('video_id')->nullable();
            $table->foreign('video_id')->references('id')->on('cards_videos')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('cards');
    }
}
