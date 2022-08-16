<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();

            $table->string('script')->nullable();
            $table->string('image')->nullable();
            $table->string('link')->nullable();


            $table->string('script2')->nullable();
            $table->string('image2')->nullable();
            $table->string('link2')->nullable();


            $table->string('script3')->nullable();
            $table->string('image3')->nullable();
            $table->string('link3')->nullable();

            $table->timestamps();
        });
        DB::table('ads')->insert([
            ['link' => null]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
