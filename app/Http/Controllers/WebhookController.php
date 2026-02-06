<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Controller untuk Xendit Webhooks
 * 
 * Endpoint:
 * - POST /webhooks/xendit - Handle Xendit payment callbacks
 * 
 * Security:
 * - Verify webhook signature
 * - Log all webhook attempts
 * - Idempotency handling
 */
class WebhookController extends Controller
{
    /**
     * Constructor - inject service
     */
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    /**
     * Handle Xendit webhook
     * 
     * Xendit akan POST ke endpoint ini ketika:
     * - Payment status berubah (pending → paid)
     * - Invoice expired
     * - Payment failed
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function xendit(Request $request)
    {
        // Log webhook attempt
        Log::channel('payment')->info('Xendit webhook received', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'payload' => $request->all(),
        ]);

        try {
            // 1. Verify webhook signature
            $webhookToken = $request->header('x-callback-token');
            
            if (!$webhookToken) {
                Log::channel('payment')->warning('Webhook without token', [
                    'ip' => $request->ip(),
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 401);
            }

            // Verify token (simple verification for development)
            // In production, implement proper signature verification
            $isValid = $this->paymentService->verifyWebhookSignature(
                $webhookToken,
                $request->header('x-signature', ''),
                $request->getContent()
            );

            if (!$isValid) {
                Log::channel('payment')->warning('Invalid webhook signature', [
                    'ip' => $request->ip(),
                    'token' => $webhookToken,
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid signature',
                ], 401);
            }

            // 2. Process webhook
            $webhookData = $request->all();
            $result = $this->paymentService->handleWebhook($webhookData);

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Webhook processed successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Webhook processing failed',
                ], 400);
            }

        } catch (\Exception $e) {
            Log::channel('payment')->error('Webhook processing error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Return 200 to prevent Xendit retry
            // (we already logged the error for manual investigation)
            return response()->json([
                'success' => false,
                'message' => 'Internal error',
            ], 200);
        }
    }
}
