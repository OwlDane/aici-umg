<?php

namespace Database\Factories;

use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassModel>
 */
class ClassModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'program_id' => Program::factory(),
            'name' => $this->faker->words(3, true),
            'code' => strtoupper($this->faker->unique()->lexify('CLAS-???')),
            'level' => 'beginner',
            'description' => $this->faker->paragraph,
            'min_score' => 0,
            'min_age' => 6,
            'max_age' => 12,
            'price' => 1000000,
            'capacity' => 20,
            'enrolled_count' => 0,
            'is_active' => true,
            'is_featured' => false,
            'sort_order' => 0,
        ];
    }
}
