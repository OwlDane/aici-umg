<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlacementTest>
 */
class PlacementTestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Placement Test ' . $this->faker->word,
            'education_level' => 'sd_mi',
            'description' => $this->faker->sentence,
            'duration_minutes' => 30,
            'passing_score' => 60,
            'is_active' => true,
            'allow_retake' => true,
            'retake_cooldown_days' => 7,
        ];
    }
}
