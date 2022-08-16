<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMainPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_pages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->longText('content')->nullable();
            $table->timestamps();
        });
        DB::table('main_pages')->insert([
            [
                'name' => 'من نحن',
                'slug' => 'about-us',
            ],
            [
                'name' => 'سياسة ارجاع المال',
                'slug' => 'refound',
            ],
            [
                'name' => 'بيان الخصوصية',
                'slug' => 'privece',
            ],
            [
                'name' => 'الشروط و الاحكام',
                'slug' => 'terms',
            ],

            [
                'name' => 'تذاكر الشراء',
                'slug' => 'ticket',
            ],
            [
                'name' => 'الطاووس vip',
                'slug' => 'vip',
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
        Schema::dropIfExists('main_pages');
    }
}
