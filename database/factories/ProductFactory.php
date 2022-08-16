<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->name(),
            'category_id'   => 1,
            'desc'          => $this->faker->text(),
            'wight'         => 0.25,
            'width' 	    => 15,
            'height'        => 30,
            'price'         => 10,
            'aval_count'    => 100,
            'main_image'    => '3665459365493eac971ac0020eaf4b52_.jpg',
            'images'        => '36db969e755b79f1a575f77c7bf7b6a8_.jpg,33c7111e4236ea3a83d3b565e3c12d3a_.jpg',
            'tags'          => 'as,asa,aaa',
            'status'        => 1,
            'receipt_days'  => 2,
            'client_id'     => Client::where('type', '=', 1)->orWhere('type', '=', 2)->get()->random()->id,
            'slug'          => Str::random(24),
        ];
    }
}
