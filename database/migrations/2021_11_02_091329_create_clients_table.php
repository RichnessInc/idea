<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->string('email')->unique();
            $table->string('password');

            $table->foreignId('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('government_id');
            $table->foreign('government_id')->references('id')->on('governments')->onUpdate('cascade')->onDelete('cascade');


            $table->string('name');

            $table->string('whatsapp_phone');

            $table->string('files')->nullable();

            $table->string('spare_phone')->nullable();

            $table->boolean('type')->default(0);

            $table->decimal('wallet', 13, 4)->default(0);

            $table->integer('points')->default(0);

            $table->decimal('debt', 13, 4)->default(0);


            $table->foreignId('address_id')->nullable();
            $table->foreign('address_id')->references('id')->on('address')->onUpdate('cascade')->onDelete('cascade');


            $table->json('serv_aval_in')->nullable();

            $table->time('shift_from')->nullable();

            $table->time('shift_to')->nullable();

            $table->string('ref')->nullable();

            $table->integer('spasial_com')->nullable();


            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->string('verify_email_token')->nullable();
            $table->boolean('verified')->default(0);
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
        Schema::dropIfExists('clients');
    }
}
