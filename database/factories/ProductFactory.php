<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(4, true),
            'description' => $this->faker->text(),
            'price' => $this->faker->numberBetween(10, 100)
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
           $product->addMediaFromUrl('https://picsum.photos/200/300')
           ->toMediaCollection('product');
        });
    }
}
