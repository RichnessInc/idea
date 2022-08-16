<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGeneralInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_info', function (Blueprint $table) {
            $table->id();
            $table->string('facebook')->nullable();
            $table->string('instgram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('whatsapp')->nullable();
            $table->boolean('senders_status')->default(1);
            $table->string('profits_section_password')->default('$2y$10$wi2a89A1IzpyjNxRWGVhNOWTxXhpXBK3mntGUBvlfdjiYLKE0VnaK');
            $table->timestamps();
        });
        DB::table('general_info')->insert([[
            'facebook'  => null,
            'instgram'  => null,
            'twitter'   => null,
            'snapchat'  => null,
            'whatsapp'  => null,
        ]]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_info');
    }
}
