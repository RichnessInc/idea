<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAds2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads2', function (Blueprint $table) {
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

            
            $table->boolean('status')->default(0);
            
            $table->timestamps();
        });
        DB::table('ads2')->insert([
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
        Schema::dropIfExists('ads2');
    }
}
