<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('pro_max_dept')->default(0);
            $table->integer('comission')->default(0);
            $table->decimal('sender_max_dept')->default(0);
            $table->integer('provider_commission')->default(0);
            $table->integer('handmade_commission')->default(0);
            $table->integer('sender_commission')->default(0);
            $table->integer('cashback_commission')->default(0);
            $table->longText('text')->nullable();
            $table->timestamps();
        });

        DB::table('payment_settings')->insert([[
            'pro_max_dept'          => 0,
            'comission'             => 0,
            'sender_max_dept'       => 0,
            'cashback_commission'   => 0
        ]]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_settings');
    }
}
