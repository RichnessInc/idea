<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('readbox', function (Blueprint $table) {
            $table->id();
            $table->decimal('readbox_cost', 13, 4);
            $table->decimal('dues', 13, 4);
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('readbox')->insert([
            [
                'readbox_cost'  => 13,
                'dues'          => 27
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('readbox');
    }
}
