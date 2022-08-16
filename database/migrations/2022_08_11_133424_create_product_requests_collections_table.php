<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRequestsCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_requests_collections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('buyer_id');

            $table->foreign('buyer_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('provieder_id');

            $table->foreign('provieder_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('sender_id')->nullable();

            $table->foreign('sender_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('product_id');

            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');

            $table->boolean('status')->default(0);

            $table->dateTime('receipt_time')->nullable();

            $table->foreignId('branch_id');

            $table->string('qr_code', 2048)->nullable();

            $table->foreignId('branch_data_id')->nullable();

            $table->boolean('soft_deleted')->default(0);

            $table->boolean('payment_status')->default(0);

            $table->foreignId('payment_method_id')->nullable();

            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onUpdate('cascade')->onDelete('cascade');

            $table->boolean('senderStatus')->default(0);

            $table->foreignId('shipping_method_id')->nullable();

            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('government_id')->nullable();

            $table->foreign('government_id')->references('id')->on('governments')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('product_requests_collections');
    }
}
