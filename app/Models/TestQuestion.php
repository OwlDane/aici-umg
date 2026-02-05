<?php

namespace App\Models;

use App\Enums\DifficultyLevel;
use App\Enums\QuestionType;
use App\Enums\TestCategory;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestQuestion extends Model
{
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = [
        'placement_test_id',
        'category',
        'type',
        'difficulty',
        'question',
        'options',
        'correct_answer',
        'explanation',
        'image',
        'points',
        'time_limit_seconds',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'points' => 'integer',
        'time_limit_seconds' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'category' => TestCategory::class,
        'type' => QuestionType::class,
        'difficulty' => DifficultyLevel::class,
    ];

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
     * Scope active questions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope by difficulty
     */
    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    /**
     * Scope ordered
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
