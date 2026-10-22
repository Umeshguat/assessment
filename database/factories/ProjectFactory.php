<?php

namespace Database\Factories;

use App\Models\Developer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return [
            'developer_id' => Developer::factory(),
            'title' => ucfirst($title),
            'slug' => str($title)->slug()->toString() . '-' . fake()->unique()->numberBetween(1, 99999),
            'city' => 'goa',
            'type' => 'apartment',
            'bhk' => fake()->numberBetween(1, 4),
            'price' => fake()->numberBetween(3000000, 20000000),
            'rera_no' => 'RERA' . fake()->numerify('######'),
            'description' => '<p>' . fake()->paragraph() . '</p>',
            'status' => 'active',
        ];
    }
}
