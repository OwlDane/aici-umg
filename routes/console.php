<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/**
 * ============================================
 * ARTISAN COMMANDS
 * ============================================
 */

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * ============================================
 * SCHEDULED TASKS
 * ============================================
 * 
 * Task scheduling untuk automated jobs
 * Run dengan: php artisan schedule:work (development)
 * Production: Setup cron job
 */

/**
 * 1. Data Cleanup - Weekly on Sunday at 2 AM
 * 
 * Cleanup old data based on retention policy:
 * - Webhook logs older than 90 days
 * - Failed payments older than 6 months
 * - Cancelled enrollments older than 1 year (anonymize)
 * - Completed enrollments older than 3 years (anonymize)
 */
Schedule::command('data:cleanup')
    ->weekly()
    ->sundays()
    ->at('02:00')
    ->timezone('Asia/Jakarta')
    ->emailOutputOnFailure(config('mail.from.address'))
    ->onSuccess(function () {
        \Illuminate\Support\Facades\Log::info('[Scheduled] Data cleanup completed successfully');
    })
    ->onFailure(function () {
        \Illuminate\Support\Facades\Log::error('[Scheduled] Data cleanup failed');
    });

/**
 * 2. Check Expired Payments - Daily at 1 AM
 * 
 * Check for expired Xendit invoices and mark as failed
 * Cancel related enrollments if payment expired
 */
Schedule::command('payments:check-expired')
    ->daily()
    ->at('01:00')
    ->timezone('Asia/Jakarta')
    ->emailOutputOnFailure(config('mail.from.address'))
    ->onSuccess(function () {
        \Illuminate\Support\Facades\Log::info('[Scheduled] Expired payments check completed');
    });

/**
 * 3. Send Class Reminders - Daily at 8 AM
 * 
 * Send email reminders to students:
 * - 1 day before class starts
 * - On class day (morning reminder)
 */
Schedule::command('enrollments:send-reminders')
    ->daily()
    ->at('08:00')
    ->timezone('Asia/Jakarta')
    ->emailOutputOnFailure(config('mail.from.address'))
    ->onSuccess(function () {
        \Illuminate\Support\Facades\Log::info('[Scheduled] Class reminders sent');
    });

/**
 * 4. Queue Worker Health Check - Every 5 minutes
 * 
 * Monitor queue health and restart if needed
 */
Schedule::command('queue:monitor')
    ->everyFiveMinutes()
    ->onFailure(function () {
        \Illuminate\Support\Facades\Log::error('[Scheduled] Queue monitor detected issues');
    });

/**
 * 5. Database Backup - Daily at 3 AM
 * 
 * Backup database untuk disaster recovery
 */
Schedule::command('backup:run')
    ->daily()
    ->at('03:00')
    ->timezone('Asia/Jakarta')
    ->emailOutputOnFailure(config('mail.from.address'))
    ->onSuccess(function () {
        \Illuminate\Support\Facades\Log::info('[Scheduled] Database backup completed');
    });

/**
 * 6. Clear Old Logs - Weekly on Monday at 4 AM
 * 
 * Clear logs older than 30 days
 */
Schedule::command('log:clear')
    ->weekly()
    ->mondays()
    ->at('04:00')
    ->timezone('Asia/Jakarta');

/**
 * 7. Cache Optimization - Daily at 5 AM
 * 
 * Clear and rebuild cache untuk optimal performance
 */
Schedule::call(function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    
    \Illuminate\Support\Facades\Log::info('[Scheduled] Cache optimization completed');
})->daily()
    ->at('05:00')
    ->timezone('Asia/Jakarta')
    ->name('cache-optimization');

/**
 * ============================================
 * PRODUCTION CRON SETUP
 * ============================================
 * 
 * Add this single cron entry to your server:
 * 
 * * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
 * 
 * This will run every minute and Laravel will determine which tasks to execute.
 * 
 * For development, use:
 * php artisan schedule:work
 */
