<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();

            $table->decimal('price', 13, 4);

            $table->string('image')->nullable();

            $table->boolean('status')->default(0);

            $table->boolean('type')->default(0);

            $table->integer('receipt_days');
            $table->boolean('soft_deleted')->default(0);

            $table->timestamps();
        });

        for ($i=0; $i < 100; $i++) {
            DB::table('gifts')->insert([
                [
                    'price' => 1000,
                    'receipt_days' => 2
                ]
            ]);
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gifts');
    }
}
