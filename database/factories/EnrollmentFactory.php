<?php

namespace Database\Factories;

use App\Enums\EnrollmentStatus;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'enrollment_number' => 'ENR-' . now()->format('Ymd') . '-' . $this->faker->unique()->numberBetween(100000, 999999),
            'user_id' => User::factory(),
            'class_id' => ClassModel::factory(),
            'status' => EnrollmentStatus::PENDING,
            'student_name' => $this->faker->name,
            'student_email' => $this->faker->safeEmail,
            'student_phone' => $this->faker->phoneNumber,
            'student_age' => 10,
            'enrolled_at' => now(),
        ];
    }
}
