<?php

namespace Database\Factories;

use App\Enums\TestStatus;
use App\Models\PlacementTest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestAttempt>
 */
class TestAttemptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'placement_test_id' => PlacementTest::factory(),
            'status' => TestStatus::IN_PROGRESS,
            'full_name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'age' => 10,
            'education_level' => 'sd_mi',
            'started_at' => now(),
            'expires_at' => now()->addMinutes(30),
            'total_questions' => 10,
        ];
    }
}
