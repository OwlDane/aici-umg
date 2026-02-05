<?php

namespace App\Models;

use App\Enums\DifficultyLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_attempt_id',
        'user_id',
        'overall_score',
        'level_achieved',
        'category_scores',
        'strengths',
        'weaknesses',
        'recommended_classes',
        'recommendation_reasons',
        'performance_summary',
        'next_steps',
    ];

    protected $casts = [
        'overall_score' => 'decimal:2',
        'category_scores' => 'array',
        'strengths' => 'array',
        'weaknesses' => 'array',
        'recommended_classes' => 'array',
        'recommendation_reasons' => 'array',
        'level_achieved' => DifficultyLevel::class,
    ];

    /**
     * Get test attempt
     */
    public function testAttempt(): BelongsTo
    {
        return $this->belongsTo(TestAttempt::class);
    }

    /**
     * Get user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get recommended classes as models
     */
    public function getRecommendedClassModels()
    {
        if (!$this->recommended_classes) {
            return collect();
        }

        $classIds = array_column($this->recommended_classes, 'class_id');
        return ClassModel::whereIn('id', $classIds)->get();
    }
}
