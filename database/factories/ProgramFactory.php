<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'education_level' => 'sd_mi',
            'description' => $this->faker->paragraph,
            'image' => null,
            'min_age' => 6,
            'max_age' => 12,
            'duration_weeks' => 8,
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
