<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Datauji>
 */
class DataujiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name,
            'umur' => $this->faker->numberBetween(0, 100),
            'lila' => $this->faker->numberBetween(0, 100),
            'tinggi' => $this->faker->numberBetween(0, 100),
            'bblr_nb' => $this->faker->boolean,
            'bblr_c45' => $this->faker->boolean,
        ];
    }
}
