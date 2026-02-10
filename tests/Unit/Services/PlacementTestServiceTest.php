<?php

use App\Enums\TestStatus;
use App\Models\PlacementTest;
use App\Models\TestAnswer;
use App\Models\TestAttempt;
use App\Models\TestQuestion;
use App\Models\User;
use App\Services\PlacementTestService;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->testService = app(PlacementTestService::class);
    $this->user = User::factory()->create();
    
    $this->placementTest = PlacementTest::create([
        'title' => 'Test Placement',
        'education_level' => 'sd_mi',
        'description' => 'Test description',
        'duration_minutes' => 30,
        'passing_score' => 60,
        'is_active' => true,
        'allow_retake' => true,
        'retake_cooldown_days' => 30,
    ]);

    TestQuestion::create([
        'placement_test_id' => $this->placementTest->id,
        'category' => 'logical_thinking',
        'type' => 'multiple_choice',
        'difficulty' => 'beginner',
        'question' => 'Setup Question?',
        'correct_answer' => 'A',
        'points' => 1,
        'is_active' => true,
    ]);
});

test('it can create test attempt', function () {
    $preAssessmentData = [
        'full_name' => 'Test Student',
        'email' => 'test@example.com',
        'age' => 10,
        'education_level' => 'sd_mi',
        'current_grade' => '4',
        'experience' => ['ai' => false, 'robotics' => false],
        'interests' => ['technology', 'games'],
    ];

    $attempt = $this->testService->createAttempt($this->placementTest, $this->user, $preAssessmentData);

    expect($attempt)->toBeInstanceOf(TestAttempt::class)
        ->and($attempt->user_id)->toBe($this->user->id)
        ->and($attempt->placement_test_id)->toBe($this->placementTest->id)
        ->and($attempt->status)->toBe(TestStatus::IN_PROGRESS)
        ->and($attempt->expires_at)->not->toBeNull();
});

test('it prevents test when inactive', function () {
    $this->placementTest->update(['is_active' => false]);

    $preAssessmentData = [
        'full_name' => 'Test Student',
        'email' => 'test@example.com',
        'age' => 10,
        'education_level' => 'sd_mi',
        'experience' => [],
        'interests' => [],
    ];

    $this->testService->createAttempt($this->placementTest, $this->user, $preAssessmentData);
})->throws(\Exception::class, 'tidak tersedia');

test('it can save answer', function () {
    $question = TestQuestion::create([
        'placement_test_id' => $this->placementTest->id,
        'category' => 'logical_thinking',
        'type' => 'multiple_choice',
        'difficulty' => 'beginner',
        'question' => 'Test question?',
        'options' => ['A', 'B', 'C', 'D'],
        'correct_answer' => 'A',
        'points' => 1,
        'is_active' => true,
    ]);

    $attempt = TestAttempt::create([
        'user_id' => $this->user->id,
        'placement_test_id' => $this->placementTest->id,
        'status' => TestStatus::IN_PROGRESS,
        'full_name' => 'Test',
        'email' => 'test@example.com',
        'age' => 10,
        'education_level' => 'sd_mi',
        'experience' => [],
        'started_at' => now(),
        'expires_at' => now()->addMinutes(30),
        'total_questions' => 1,
    ]);

    $answer = $this->testService->saveAnswer($attempt, $question, 'A', 10);

    expect($answer)->toBeInstanceOf(TestAnswer::class)
        ->and($answer->test_attempt_id)->toBe($attempt->id)
        ->and($answer->test_question_id)->toBe($question->id)
        ->and($answer->is_correct)->toBeTrue();
});

test('it calculates correct score', function () {
    // Create questions
    $question1 = TestQuestion::create([
        'placement_test_id' => $this->placementTest->id,
        'category' => 'logical_thinking',
        'type' => 'multiple_choice',
        'difficulty' => 'beginner',
        'question' => 'Question 1?',
        'correct_answer' => 'A',
        'points' => 1,
        'is_active' => true,
    ]);

    $question2 = TestQuestion::create([
        'placement_test_id' => $this->placementTest->id,
        'category' => 'logical_thinking',
        'type' => 'multiple_choice',
        'difficulty' => 'beginner',
        'question' => 'Question 2?',
        'correct_answer' => 'B',
        'points' => 1,
        'is_active' => true,
    ]);

    $attempt = TestAttempt::create([
        'user_id' => $this->user->id,
        'placement_test_id' => $this->placementTest->id,
        'status' => TestStatus::IN_PROGRESS,
        'full_name' => 'Test',
        'email' => 'test@example.com',
        'age' => 10,
        'education_level' => 'sd_mi',
        'experience' => [],
        'started_at' => now(),
        'expires_at' => now()->addMinutes(30),
        'total_questions' => 2,
    ]);

    // Answer correctly
    $this->testService->saveAnswer($attempt, $question1, 'A', 10);
    // Answer incorrectly
    $this->testService->saveAnswer($attempt, $question2, 'C', 10);

    $completedAttempt = $this->testService->completeTest($attempt);

    expect($completedAttempt->status)->toBe(TestStatus::COMPLETED)
        ->and((float) $completedAttempt->score)->toBe(50.0)
        ->and($completedAttempt->completed_at)->not->toBeNull();
});

test('it determines correct level', function () {
    $attempt = TestAttempt::create([
        'user_id' => $this->user->id,
        'placement_test_id' => $this->placementTest->id,
        'status' => TestStatus::IN_PROGRESS,
        'full_name' => 'Test',
        'email' => 'test@example.com',
        'age' => 10,
        'education_level' => 'sd_mi',
        'experience' => [],
        'started_at' => now(),
        'total_questions' => 1,
    ]);

    // Test different score levels by adding answers
    // Level determination logic in PlacementTestService uses score thresholds:
    // beginner: 0-39, elementary: 40-59, intermediate: 60-79, advanced: 80-100
    
    // Advanced (High score)
    $q = TestQuestion::first();
    $this->testService->saveAnswer($attempt, $q, 'A', 1); // Correct -> 100%
    $this->testService->completeTest($attempt);
    expect($attempt->fresh()->level_result)->toBe('advanced');

    // Beginner (Low score)
    $attempt2 = TestAttempt::create([
        'user_id' => $this->user->id,
        'placement_test_id' => $this->placementTest->id,
        'status' => TestStatus::IN_PROGRESS,
        'full_name' => 'Test',
        'email' => 'test@example.com',
        'age' => 10,
        'education_level' => 'sd_mi',
        'experience' => [],
        'started_at' => now(),
        'total_questions' => 1,
    ]);
    $this->testService->saveAnswer($attempt2, $q, 'B', 1); // Incorrect -> 0%
    $this->testService->completeTest($attempt2);
    expect($attempt2->fresh()->level_result)->toBe('beginner');
});

test('it prevents duplicate answers', function () {
    $question = TestQuestion::create([
        'placement_test_id' => $this->placementTest->id,
        'category' => 'logical_thinking',
        'type' => 'multiple_choice',
        'difficulty' => 'beginner',
        'question' => 'Test question?',
        'correct_answer' => 'A',
        'points' => 1,
        'is_active' => true,
    ]);

    $attempt = TestAttempt::create([
        'user_id' => $this->user->id,
        'placement_test_id' => $this->placementTest->id,
        'status' => TestStatus::IN_PROGRESS,
        'full_name' => 'Test',
        'email' => 'test@example.com',
        'age' => 10,
        'education_level' => 'sd_mi',
        'experience' => [],
        'started_at' => now(),
        'expires_at' => now()->addMinutes(30),
        'total_questions' => 1,
    ]);

    // First answer
    $this->testService->saveAnswer($attempt, $question, 'A', 10);

    // Try to answer again
    $this->testService->saveAnswer($attempt, $question, 'B', 10);
})->throws(\Exception::class, 'sudah dijawab');

test('it enforces retake cooldown', function () {
    $this->placementTest->update([
        'allow_retake' => true,
        'retake_cooldown_days' => 7
    ]);

    TestAttempt::create([
        'user_id' => $this->user->id,
        'placement_test_id' => $this->placementTest->id,
        'status' => TestStatus::COMPLETED,
        'full_name' => 'Test',
        'email' => 'test@example.com',
        'age' => 10,
        'education_level' => 'sd_mi',
        'experience' => [],
        'started_at' => now()->subDays(1),
        'completed_at' => now()->subDays(1),
        'total_questions' => 1,
    ]);

    $preAssessmentData = [
        'full_name' => 'Test Student',
        'email' => 'test@example.com',
        'age' => 10,
        'education_level' => 'sd_mi',
        'experience' => [],
    ];

    $this->testService->createAttempt($this->placementTest, $this->user, $preAssessmentData);
})->throws(\Exception::class, 'dapat mengulang test dalam');

test('it calculates scores with difficulty weights', function () {
    $easyQuestion = TestQuestion::create([
        'placement_test_id' => $this->placementTest->id,
        'category' => 'logical_thinking',
        'type' => 'multiple_choice',
        'difficulty' => 'beginner',
        'question' => 'Easy?',
        'correct_answer' => 'A',
        'points' => 10,
        'is_active' => true,
    ]);

    $hardQuestion = TestQuestion::create([
        'placement_test_id' => $this->placementTest->id,
        'category' => 'logical_thinking',
        'type' => 'multiple_choice',
        'difficulty' => 'advanced',
        'question' => 'Hard?',
        'correct_answer' => 'B',
        'points' => 10,
        'is_active' => true,
    ]);

    $attempt = TestAttempt::create([
        'user_id' => $this->user->id,
        'placement_test_id' => $this->placementTest->id,
        'status' => TestStatus::IN_PROGRESS,
        'full_name' => 'Test',
        'email' => 'test@example.com',
        'age' => 10,
        'education_level' => 'sd_mi',
        'experience' => [],
        'started_at' => now(),
        'total_questions' => 2,
    ]);

    $this->testService->saveAnswer($attempt, $hardQuestion, 'B', 10);
    $this->testService->saveAnswer($attempt, $easyQuestion, 'B', 10);

    $completedAttempt = $this->testService->completeTest($attempt);

    expect((float) $completedAttempt->score)->toBe(66.67);
});
