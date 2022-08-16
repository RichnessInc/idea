<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToAltaawusVipRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('altaawus_vip_requests', function (Blueprint $table) {
            $table->string('email');
            $table->string('whatsapp_phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('altaawus_vip_requests', function (Blueprint $table) {
            //
        });
    }
}
