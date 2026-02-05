<?php

namespace App\Models;

use App\Enums\TestStatus;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestAttempt extends Model
{
    use HasFactory, SoftDeletes, HasStatus;

    protected $fillable = [
        'user_id',
        'placement_test_id',
        'status',
        'full_name',
        'email',
        'age',
        'education_level',
        'current_grade',
        'experience',
        'interests',
        'started_at',
        'completed_at',
        'expires_at',
        'time_spent_seconds',
        'total_questions',
        'answered_questions',
        'correct_answers',
        'score',
        'level_result',
    ];

    protected $casts = [
        'experience' => 'array',
        'interests' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'expires_at' => 'datetime',
        'age' => 'integer',
        'time_spent_seconds' => 'integer',
        'total_questions' => 'integer',
        'answered_questions' => 'integer',
        'correct_answers' => 'integer',
        'score' => 'decimal:2',
        'status' => TestStatus::class,
    ];

    /**
     * Get user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get placement test
     */
    public function placementTest(): BelongsTo
    {
        return $this->belongsTo(PlacementTest::class);
    }

    /**
     * Get answers
     */
    public function answers(): HasMany
    {
        return $this->hasMany(TestAnswer::class);
    }

    /**
     * Get result
     */
    public function result(): HasOne
    {
        return $this->hasOne(TestResult::class);
    }

    /**
     * Scope completed attempts
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', TestStatus::COMPLETED->value);
    }

    /**
     * Scope in progress
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', TestStatus::IN_PROGRESS->value);
    }

    /**
     * Check if test is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && now()->isAfter($this->expires_at);
    }

    /**
     * Check if test is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === TestStatus::COMPLETED;
    }

    /**
     * Calculate completion percentage
     */
    public function getCompletionPercentage(): float
    {
        if ($this->total_questions === 0) {
            return 0;
        }
        return ($this->answered_questions / $this->total_questions) * 100;
    }
}
