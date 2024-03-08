<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->word;

        return [
            'name' => $name,
            'store_id' => 1,
            'tenant_id' => 1,
            'slug' => str($name)->slug(),
            'description' => fake()->sentence
        ];
    }
}
