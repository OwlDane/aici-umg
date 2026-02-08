<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\Request;

/**
 * User Payment API Controller
 * 
 * Authenticated API untuk mobile app
 * User dapat melihat payment mereka sendiri
 */
class UserPaymentController extends Controller
{
    /**
     * Display user's payments
     * 
     * GET /api/v1/user/payments
     * 
     * Query params:
     * - status: filter by status
     * - with_enrollment: include enrollment data
     */
    public function index(Request $request)
    {
        $query = $request->user()
            ->payments();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Include enrollment if requested
        if ($request->boolean('with_enrollment')) {
            $query->with('enrollment.class');
        }

        $payments = $query->latest()->get();

        return PaymentResource::collection($payments);
    }

    /**
     * Display specific payment
     * 
     * GET /api/v1/user/payments/{id}
     */
    public function show(Request $request, int $id)
    {
        $payment = $request->user()
            ->payments()
            ->with('enrollment.class')
            ->findOrFail($id);

        return new PaymentResource($payment);
    }
}
