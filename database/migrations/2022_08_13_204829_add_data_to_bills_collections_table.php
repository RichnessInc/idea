<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToBillsCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('bills_collections', 'product_request_id'))
        {
            Schema::table('bills_collections', function (Blueprint $table)
            {
                $table->dropForeign('product_request_id');
                $table->dropColumn('product_request_id');
            });
        }
        Schema::table('bills_collections', function (Blueprint $table) {
            $table->foreignId('product_request_id')->nullable();
            $table->foreign('product_request_id')->references('id')->on('product_requests_collections')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bills_collections', function (Blueprint $table) {
            //
        });
    }
}
