<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class API Resource
 * 
 * Transform ClassModel untuk API response
 */
class ClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'program_id' => $this->program_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'code' => $this->code,
            'description' => $this->description,
            'level' => $this->level,
            'price' => $this->price,
            'price_formatted' => formatCurrency($this->price),
            'duration_hours' => $this->duration_hours,
            'max_students' => $this->max_students,
            'min_age' => $this->min_age,
            'max_age' => $this->max_age,
            'min_score' => $this->min_score,
            'prerequisites' => $this->prerequisites,
            'learning_outcomes' => $this->learning_outcomes,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
            
            // Relationships
            'program' => new ProgramResource($this->whenLoaded('program')),
            'schedules' => ClassScheduleResource::collection($this->whenLoaded('schedules')),
            'schedules_count' => $this->when(
                $this->relationLoaded('schedules'),
                fn() => $this->schedules->count()
            ),
            
            // Computed
            'available_slots' => $this->when(
                $this->relationLoaded('schedules'),
                fn() => $this->schedules->sum(fn($s) => $s->getRemainingSlots())
            ),
            
            // Timestamps
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
