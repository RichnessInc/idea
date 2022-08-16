<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataGeneralInfoTsble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_info', function (Blueprint $table) {
            $table->string('tel_fax')->nullable();
            $table->string('hot_line')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
