<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnrollmentResource;
use Illuminate\Http\Request;

/**
 * User Enrollment API Controller
 * 
 * Authenticated API untuk mobile app
 * User dapat melihat enrollment mereka sendiri
 */
class UserEnrollmentController extends Controller
{
    /**
     * Display user's enrollments
     * 
     * GET /api/v1/user/enrollments
     * 
     * Query params:
     * - status: filter by status
     * - with_payment: include payment data
     * - with_class: include class data
     */
    public function index(Request $request)
    {
        $query = $request->user()
            ->enrollments()
            ->with(['class.program', 'classSchedule']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Include payment if requested
        if ($request->boolean('with_payment')) {
            $query->with('payment');
        }

        $enrollments = $query->latest('enrolled_at')->get();

        return EnrollmentResource::collection($enrollments);
    }

    /**
     * Display specific enrollment
     * 
     * GET /api/v1/user/enrollments/{id}
     */
    public function show(Request $request, int $id)
    {
        $enrollment = $request->user()
            ->enrollments()
            ->with(['class.program', 'classSchedule', 'payment'])
            ->findOrFail($id);

        return new EnrollmentResource($enrollment);
    }
}
