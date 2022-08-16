<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->json('bills_data');

            $table->decimal('total_price', 13, 4);

            $table->decimal('total_shipping', 13, 4)->default(0);


            $table->json('payment_data');
            $table->string('paymentmethod');

            $table->foreignId('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');

            $table->string('reference_number')->nullable();
            $table->tinyInteger('sender_commission')->default(25);
            $table->tinyInteger('cashback_commission')->default(3);
            $table->tinyInteger('marketing_commission')->default(3);
            $table->tinyInteger('provider_commission')->default(20);
            $table->tinyInteger('handmade_commission')->default(25);
            $table->longText('qr_code')->nullable();
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
        Schema::dropIfExists('receipts');
    }
}
