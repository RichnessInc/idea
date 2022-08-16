<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataProToProductRequestsCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_requests_collections', function (Blueprint $table) {
            $table->foreignId('receipt_id')->nullable();
            $table->foreign('receipt_id')->references('id')->on('receipt_collections')->onUpdate('cascade')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_requests_collections', function (Blueprint $table) {
            //
        });
    }
}
