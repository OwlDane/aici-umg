<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Xendit API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration untuk Xendit Payment Gateway
    | 
    | IMPORTANT: Jangan pernah hardcode credentials di sini!
    | Semua credentials harus di .env file
    |
    */

    // API Keys (dari .env)
    'secret_key' => env('XENDIT_SECRET_KEY'),
    'public_key' => env('XENDIT_PUBLIC_KEY'),
    
    // Webhook verification token
    'webhook_token' => env('XENDIT_WEBHOOK_TOKEN'),
    
    // Environment (development/production)
    'environment' => env('XENDIT_ENVIRONMENT', 'development'),
    
    // API Base URL
    'api_url' => env('XENDIT_ENVIRONMENT', 'development') === 'production'
        ? 'https://api.xendit.co'
        : 'https://api.xendit.co', // Same URL for both, but we track environment
    
    // Invoice Configuration
    'invoice' => [
        // Invoice expiration (in seconds)
        'expiration' => 86400, // 24 hours
        
        // Success redirect URL
        'success_redirect_url' => env('APP_URL') . '/enrollments/{enrollment_id}?payment=success',
        
        // Failure redirect URL
        'failure_redirect_url' => env('APP_URL') . '/enrollments/{enrollment_id}?payment=failed',
    ],
    
    // Payment Methods
    'payment_methods' => [
        'bank_transfer' => true,
        'credit_card' => true,
        'ewallet' => true,
        'retail_outlet' => true,
        'qris' => true,
    ],
    
    // Admin Fee Configuration
    'admin_fee' => [
        'enabled' => true,
        'percentage' => 0, // 0% (flat fee only)
        'flat_amount' => 5000, // Rp 5.000
    ],
];
