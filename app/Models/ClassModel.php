<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\HasSlug;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassModel extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasSlug, Auditable;

    protected $table = 'classes';

    protected $fillable = [
        'program_id',
        'name',
        'slug',
        'code',
        'level',
        'description',
        'curriculum',
        'prerequisites',
        'min_score',
        'min_age',
        'max_age',
        'duration_hours',
        'total_sessions',
        'price',
        'capacity',
        'enrolled_count',
        'image',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'curriculum' => 'array',
        'prerequisites' => 'array',
        'min_score' => 'integer',
        'min_age' => 'integer',
        'max_age' => 'integer',
        'duration_hours' => 'integer',
        'total_sessions' => 'integer',
        'price' => 'decimal:2',
        'capacity' => 'integer',
        'enrolled_count' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $slugSource = 'name';

    /**
     * Get program
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get schedules
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class, 'class_id');
    }

    /**
     * Get enrollments
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }

    /**
     * Scope active classes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope featured classes
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope by level
     */
    public function scopeByLevel($query, string $level)
    {
        return $query->where('level', $level);
    }

    /**
     * Scope available (has capacity)
     */
    public function scopeAvailable($query)
    {
        return $query->whereColumn('enrolled_count', '<', 'capacity');
    }

    /**
     * Check if class has available slots
     */
    public function hasAvailableSlots(): bool
    {
        return $this->enrolled_count < $this->capacity;
    }

    /**
     * Get remaining slots
     */
    public function getRemainingSlots(): int
    {
        return max(0, $this->capacity - $this->enrolled_count);
    }

    /**
     * Increment enrolled count
     */
    public function incrementEnrolled(): void
    {
        $this->increment('enrolled_count');
    }

    /**
     * Decrement enrolled count
     */
    public function decrementEnrolled(): void
    {
        $this->decrement('enrolled_count');
    }
}
