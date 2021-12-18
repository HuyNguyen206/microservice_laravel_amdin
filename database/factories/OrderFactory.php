<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $carbon = Carbon::now();
        $date1 = $carbon->copy()->subDays(1);
        $date2 = $carbon->copy()->subDays(2);
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'created_at' => Arr::random([$carbon, $date1, $date2])
        ];
    }
}
