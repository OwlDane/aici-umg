<?php

namespace Database\Factories;

use App\Enums\DifficultyLevel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestResult>
 */
class TestResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'test_attempt_id' => \App\Models\TestAttempt::factory(),
            'user_id' => User::factory(),
            'overall_score' => 85.00,
            'level_achieved' => DifficultyLevel::ADVANCED,
            'category_scores' => [],
            'strengths' => [],
            'weaknesses' => [],
        ];
    }
}
