<?php

use App\Enums\EnrollmentStatus;
use App\Models\ClassModel;
use App\Models\Enrollment;
use App\Models\Program;
use App\Models\User;
use App\Services\EnrollmentService;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->enrollmentService = app(EnrollmentService::class);
    $this->user = User::factory()->create();
    
    $program = Program::create([
        'name' => 'Test Program',
        'education_level' => 'sd_mi',
        'description' => 'Test description',
        'min_age' => 6,
        'max_age' => 12,
        'duration_weeks' => 8,
        'is_active' => true,
    ]);
    
    $this->class = ClassModel::create([
        'program_id' => $program->id,
        'code' => 'TEST-001',
        'name' => 'Test Class',
        'level' => 'beginner',
        'price' => 1000000,
        'capacity' => 20,
        'enrolled_count' => 0,
        'is_active' => true,
    ]);
});

test('it can create enrollment', function () {
    $data = [
        'student_name' => 'Test Student',
        'student_email' => 'test@example.com',
        'student_phone' => '08123456789',
        'student_age' => 10,
        'parent_name' => 'Test Parent',
        'parent_phone' => '08123456789',
        'parent_email' => 'parent@example.com',
    ];

    $enrollment = $this->enrollmentService->createEnrollment($this->user, $this->class, $data);

    expect($enrollment)->toBeInstanceOf(Enrollment::class)
        ->and($enrollment->user_id)->toBe($this->user->id)
        ->and($enrollment->class_id)->toBe($this->class->id)
        ->and($enrollment->status)->toBe(EnrollmentStatus::PENDING)
        ->and($enrollment->enrollment_number)->not->toBeNull();
});

test('it generates unique enrollment numbers', function () {
    $data = [
        'student_name' => 'Test Student',
        'student_email' => 'test@example.com',
        'student_phone' => '08123456789',
        'student_age' => 10,
        'parent_name' => 'Test Parent',
        'parent_phone' => '08123456789',
    ];

    $user2 = User::factory()->create();
    $enrollment1 = $this->enrollmentService->createEnrollment($this->user, $this->class, $data);
    $enrollment2 = $this->enrollmentService->createEnrollment($user2, $this->class, $data);

    expect($enrollment1->enrollment_number)->not->toBe($enrollment2->enrollment_number);
});

test('it can confirm enrollment', function () {
    $enrollment = Enrollment::create([
        'user_id' => $this->user->id,
        'class_id' => $this->class->id,
        'enrollment_number' => 'ENR-TEST-001',
        'student_name' => 'Test Student',
        'student_email' => 'test@example.com',
        'student_phone' => '08123456789',
        'student_age' => 10,
        'parent_name' => 'Test Parent',
        'parent_phone' => '08123456789',
        'status' => EnrollmentStatus::PENDING,
    ]);

    $confirmedEnrollment = $this->enrollmentService->confirmEnrollment($enrollment);

    expect($confirmedEnrollment->status)->toBe(EnrollmentStatus::CONFIRMED)
        ->and($confirmedEnrollment->confirmed_at)->not->toBeNull();
});

test('it increments class enrolled count on confirmation', function () {
    $initialCount = $this->class->enrolled_count;

    $enrollment = Enrollment::create([
        'user_id' => $this->user->id,
        'class_id' => $this->class->id,
        'enrollment_number' => 'ENR-TEST-001',
        'student_name' => 'Test Student',
        'student_email' => 'test@example.com',
        'student_phone' => '08123456789',
        'student_age' => 10,
        'parent_name' => 'Test Parent',
        'parent_phone' => '08123456789',
        'status' => EnrollmentStatus::PENDING,
    ]);

    $this->enrollmentService->confirmEnrollment($enrollment);

    $this->class->refresh();
    expect($this->class->enrolled_count)->toBe($initialCount + 1);
});

test('it can cancel enrollment', function () {
    $enrollment = Enrollment::create([
        'user_id' => $this->user->id,
        'class_id' => $this->class->id,
        'enrollment_number' => 'ENR-TEST-001',
        'student_name' => 'Test Student',
        'student_email' => 'test@example.com',
        'student_phone' => '08123456789',
        'student_age' => 10,
        'parent_name' => 'Test Parent',
        'parent_phone' => '08123456789',
        'status' => EnrollmentStatus::PENDING,
    ]);

    $reason = 'Test cancellation reason';
    $cancelledEnrollment = $this->enrollmentService->cancelEnrollment($enrollment, $reason);

    expect($cancelledEnrollment->status)->toBe(EnrollmentStatus::CANCELLED)
        ->and($cancelledEnrollment->cancellation_reason)->toBe($reason)
        ->and($cancelledEnrollment->cancelled_at)->not->toBeNull();
});

test('it prevents enrollment when class is full', function () {
    $this->class->update([
        'capacity' => 1,
        'enrolled_count' => 1,
    ]);

    $data = [
        'student_name' => 'Test Student',
        'student_email' => 'test@example.com',
        'student_phone' => '08123456789',
        'student_age' => 10,
        'parent_name' => 'Test Parent',
        'parent_phone' => '08123456789',
    ];

    $this->enrollmentService->createEnrollment($this->user, $this->class, $data);
})->throws(Exception::class, 'Kelas sudah penuh');

test('it prevents enrollment when class is inactive', function () {
    $this->class->update(['is_active' => false]);

    $data = [
        'student_name' => 'Test Student',
        'student_email' => 'test@example.com',
        'student_phone' => '08123456789',
        'student_age' => 10,
        'parent_name' => 'Test Parent',
        'parent_phone' => '08123456789',
    ];

    $this->enrollmentService->createEnrollment($this->user, $this->class, $data);
})->throws(Exception::class, 'Kelas tidak tersedia');

test('it validates prerequisites minimum score', function () {
    $this->class->update(['min_score' => 80]);

    $testResult = \App\Models\TestResult::factory()->create([
        'user_id' => $this->user->id,
        'overall_score' => 75,
    ]);

    $data = [
        'student_name' => 'Test Student',
        'student_email' => 'test@example.com',
        'student_phone' => '08123456789',
        'student_age' => 10,
        'test_result_id' => $testResult->id,
    ];

    $this->enrollmentService->createEnrollment($this->user, $this->class, $data);
})->throws(\Exception::class, 'belum memenuhi syarat minimum');

test('it validates age requirements', function () {
    $this->class->update(['min_age' => 12]);

    $data = [
        'student_name' => 'Young Student',
        'student_email' => 'young@example.com',
        'student_phone' => '08123456789',
        'student_age' => 10,
    ];

    $this->enrollmentService->createEnrollment($this->user, $this->class, $data);
})->throws(\Exception::class, 'Usia minimal untuk kelas ini adalah 12 tahun');

test('it can complete enrollment', function () {
    $enrollment = Enrollment::create([
        'user_id' => $this->user->id,
        'class_id' => $this->class->id,
        'enrollment_number' => 'ENR-TEST-001',
        'student_name' => 'Test Student',
        'student_email' => 'test@example.com',
        'student_phone' => '08123456789',
        'student_age' => 10,
        'status' => EnrollmentStatus::CONFIRMED,
    ]);

    $completedEnrollment = $this->enrollmentService->completeEnrollment($enrollment);

    expect($completedEnrollment->status)->toBe(EnrollmentStatus::COMPLETED)
        ->and($completedEnrollment->completed_at)->not->toBeNull();
});

test('it can cancel and restore capacity', function () {
    $initialCount = $this->class->enrolled_count;
    
    $enrollment = Enrollment::create([
        'user_id' => $this->user->id,
        'class_id' => $this->class->id,
        'enrollment_number' => 'ENR-TEST-001',
        'student_name' => 'Test Student',
        'student_email' => 'test@example.com',
        'student_phone' => '08123456789',
        'student_age' => 10,
        'status' => EnrollmentStatus::PENDING,
    ]);
    
    // Simulate increment from creation
    $this->class->incrementEnrolled();
    expect($this->class->fresh()->enrolled_count)->toBe($initialCount + 1);

    $this->enrollmentService->cancelEnrollment($enrollment, 'User cancelled');

    expect($this->class->fresh()->enrolled_count)->toBe($initialCount);
});
