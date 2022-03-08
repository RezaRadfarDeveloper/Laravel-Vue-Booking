<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class BookableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        $suffix = [
            'Villa',
            'Home',
            'Cottage',
            'Luxury Villa',
            'Rooms',
            'Cheap Rooms',
            'Luxury Rooms',
            'Fancy Rooms',

        ];
        return [
            'title' => $this->faker->city().' '.Arr::random($suffix),
            'description' => $this->faker->text(),
            'price' => random_int(15,640)
        ];
    }
}
