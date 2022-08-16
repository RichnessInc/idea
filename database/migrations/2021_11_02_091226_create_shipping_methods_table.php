<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateShippingMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status')->default(0);
            $table->decimal('price',13, 4);
            $table->boolean('soft_deleted')->default(0);
            $table->timestamps();
        });

        DB::table('shipping_methods')->insert([
            [
                'name' => 'مندوب من نفس المحافة',
                'status' => 1,
                'price' => 50,
            ],
            [
                'name' => 'مندوب من خارج المحافة',
                'status' => 1,
                'price' => 50,
            ],
            [
                'name' => 'رصيد الحساب',
                'status' => 1,
                'price' => 0,
            ],
            [
                'name' => 'شركة شحن - ReadBox',
                'status' => 1,
                'price' => 0,
            ],
            [
                'name' => 'توصيل الطاووس',
                'status' => 1,
                'price' => 0,
            ],
            [
                'name' => 'توصيل الطاووس الراقص',
                'status' => 1,
                'price' => 0,
            ],
            [
                'name' => 'توصيل هدايا مع اقامة حفل بفرقة الطاووس',
                'status' => 1,
                'price' => 0,
            ],
            [
                'name' => 'شحن دولي DHL خارج الدولة',
                'status' => 1,
                'price' => 0,
            ],
            [
                'name' => 'الاستلام بنفسي من المتجر دون رسوم توصيل',
                'status' => 1,
                'price' => 0,
            ],




        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_methods');
    }
}
