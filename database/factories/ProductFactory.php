<?php

namespace Database\Factories;

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
            'image_path' => $this->faker->imageUrl(),
            'price' => $this->faker->numberBetween(10, 100)
        ];
    }
}
