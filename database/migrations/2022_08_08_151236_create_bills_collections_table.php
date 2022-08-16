<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills_collections', function (Blueprint $table) {
            $table->id();

            $table->json('item_data');

            $table->decimal('item_price', 13, 4);

            $table->decimal('shipping', 13, 4)->default(0);

            $table->decimal('total_price', 13, 4);

            $table->boolean('status')->default(0);

            $table->foreignId('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('address_id')->nullable();
            $table->foreign('address_id')->references('id')->on('address')->onUpdate('cascade')->onDelete('cascade');

            $table->json('shipping_method_data')->nullable();

            $table->string('reference_number')->unique();

            $table->foreignId('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');



            $table->json('shipping_data')->nullable();

            $table->boolean('soft_deleted')->default(0);
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
        Schema::dropIfExists('bills_collections');
    }
}
