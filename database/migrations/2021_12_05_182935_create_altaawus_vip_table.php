<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAltaawusVipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('altaawus_vip', function (Blueprint $table) {
            $table->id();
            $table->longText('text')->nullable();
            $table->timestamps();
        });

        DB::table('altaawus_vip')->insert([
            ['text' => NULL]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('altaawus_vip');
    }
}
