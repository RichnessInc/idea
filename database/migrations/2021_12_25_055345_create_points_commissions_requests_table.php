<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointsCommissionsRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points_commissions_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->nullable();
            $table->foreign('type_id')->references('id')->on('points_commissions')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('points_commissions_requests');
    }
}
