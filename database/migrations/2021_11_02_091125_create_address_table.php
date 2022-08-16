<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
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
            $table->boolean('branch')->default(0);
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
        Schema::dropIfExists('address');
    }
}
