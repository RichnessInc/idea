<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAltaawusVipRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('altaawus_vip_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('government_id');
            $table->foreign('government_id')->references('id')->on('governments')->onUpdate('cascade')->onDelete('cascade');
            $table->string('street');
            $table->integer('build_no');
            $table->string('sector')->nullable();
            $table->integer('floor')->nullable();
            $table->integer('unit_no')->nullable();
            $table->string('details')->nullable();
            $table->foreignId('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('shipping_method_id')->nullable();
            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('altaawus_vip_requests');
    }
}
