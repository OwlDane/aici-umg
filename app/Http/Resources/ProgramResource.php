<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Program API Resource
 * 
 * Transform Program model untuk API response
 * Digunakan untuk mobile app dan public API
 */
class ProgramResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'education_level' => $this->education_level,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
            
            // Relationships (conditional loading)
            'classes' => ClassResource::collection($this->whenLoaded('classes')),
            'classes_count' => $this->when(
                $this->relationLoaded('classes'),
                fn() => $this->classes->count()
            ),
            
            // Timestamps
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
