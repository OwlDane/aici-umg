<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\HasSlug;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlacementTest extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasSlug, Auditable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'education_level',
        'duration_minutes',
        'total_questions',
        'passing_score',
        'instructions',
        'is_active',
        'show_result_immediately',
        'allow_retake',
        'retake_cooldown_days',
    ];

    protected $casts = [
        'duration_minutes' => 'integer',
        'total_questions' => 'integer',
        'passing_score' => 'integer',
        'is_active' => 'boolean',
        'show_result_immediately' => 'boolean',
        'allow_retake' => 'boolean',
        'retake_cooldown_days' => 'integer',
    ];

    protected $slugSource = 'title';

    /**
     * Get questions
     */
    public function questions(): HasMany
    {
        return $this->hasMany(TestQuestion::class);
    }

    /**
     * Get attempts
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(TestAttempt::class);
    }

    /**
     * Scope active tests
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by education level
     */
    public function scopeForEducationLevel($query, string $level)
    {
        return $query->where('education_level', $level);
    }

    /**
     * Get active questions
     */
    public function getActiveQuestions()
    {
        return $this->questions()->where('is_active', true)->orderBy('sort_order')->get();
    }
}
