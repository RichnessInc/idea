<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->foreignId('category_id');

            $table->foreign('category_id')->references('id')->on('product_categories')->onUpdate('cascade')->onDelete('cascade');

            $table->text('desc');

            $table->float('wight');

            $table->float('width');

            $table->float('height');

            $table->decimal('price', 13, 4);

            $table->integer('aval_count');

            $table->text('main_image');

            $table->text('images');

            $table->text('tags');

            $table->boolean('status')->default(0);

            $table->integer('receipt_days');

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
        Schema::dropIfExists('products');
    }
}
