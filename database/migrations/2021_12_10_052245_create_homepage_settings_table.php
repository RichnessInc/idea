<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHomepageSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homepage_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('slider_1')->default(0);
            $table->boolean('slider_2')->default(0);
            $table->boolean('slider_3')->default(0);
            $table->boolean('slider_4')->default(0);

            $table->boolean('uper_ads')->default(0);
            $table->boolean('down_ads')->default(0);
            $table->timestamps();
        });

        DB::table('homepage_settings')->insert([
            ['slider_1' => 0]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('homepage_settings');
    }
}
