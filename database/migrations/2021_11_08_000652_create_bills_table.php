<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
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
        Schema::dropIfExists('bills');
    }
}
