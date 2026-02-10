<?php

namespace Database\Factories;

use App\Enums\PaymentStatus;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . strtoupper($this->faker->unique()->bothify('??###')),
            'enrollment_id' => Enrollment::factory(),
            'user_id' => User::factory(),
            'amount' => 1000000,
            'admin_fee' => 25000,
            'total_amount' => 1025000,
            'currency' => 'IDR',
            'payment_method' => 'VA',
            'status' => PaymentStatus::PENDING,
            'expired_at' => now()->addDays(1),
        ];
    }
}
