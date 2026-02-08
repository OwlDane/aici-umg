<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Enrollment API Resource
 * 
 * Transform Enrollment model untuk API response
 * SECURITY: Mask sensitive data untuk non-admin
 */
class EnrollmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isOwner = $request->user()?->id === $this->user_id;
        $isAdmin = $request->user()?->isAdmin() ?? false;
        $canViewFull = $isOwner || $isAdmin;

        return [
            'id' => $this->id,
            'enrollment_number' => $this->enrollment_number,
            'user_id' => $this->user_id,
            'class_id' => $this->class_id,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            
            // Student data (masked untuk non-owner/non-admin)
            'student_name' => $canViewFull ? $this->student_name : $this->masked_student_name,
            'student_email' => $canViewFull ? $this->student_email : $this->masked_student_email,
            'student_phone' => $canViewFull ? $this->student_phone : $this->masked_student_phone,
            'student_age' => $this->student_age,
            'student_grade' => $this->student_grade,
            
            // Parent data (only for owner/admin)
            'parent_name' => $this->when($canViewFull, $this->parent_name),
            'parent_phone' => $this->when($canViewFull, $this->parent_phone),
            'parent_email' => $this->when($canViewFull, $this->parent_email),
            
            // Additional info
            'special_requirements' => $this->when($canViewFull, $this->special_requirements),
            'notes' => $this->when($isAdmin, $this->notes),
            
            // Relationships
            'class' => new ClassResource($this->whenLoaded('class')),
            'schedule' => new ClassScheduleResource($this->whenLoaded('classSchedule')),
            'payment' => new PaymentResource($this->whenLoaded('payment')),
            
            // Timestamps
            'enrolled_at' => $this->enrolled_at?->toISOString(),
            'confirmed_at' => $this->confirmed_at?->toISOString(),
            'cancelled_at' => $this->cancelled_at?->toISOString(),
            'completed_at' => $this->completed_at?->toISOString(),
            'cancellation_reason' => $this->when($canViewFull, $this->cancellation_reason),
            
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
