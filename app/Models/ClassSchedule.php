<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'class_id',
        'batch_name',
        'start_date',
        'end_date',
        'day_of_week',
        'start_time',
        'end_time',
        'location',
        'instructor_name',
        'capacity',
        'enrolled_count',
        'is_available',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'capacity' => 'integer',
        'enrolled_count' => 'integer',
        'is_available' => 'boolean',
    ];

    /**
     * Get class
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    /**
     * Get enrollments
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Scope available schedules
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)
            ->where('start_date', '>', now())
            ->whereColumn('enrolled_count', '<', 'capacity');
    }

    /**
     * Scope upcoming schedules
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    /**
     * Check if schedule has available slots
     */
    public function hasAvailableSlots(): bool
    {
        return $this->is_available && $this->enrolled_count < $this->capacity;
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
