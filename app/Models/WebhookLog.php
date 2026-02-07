<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * WebhookLog Model
 * 
 * Store all incoming webhook requests for security audit and debugging
 * 
 * Security Features:
 * - Track all webhook attempts
 * - Detect replay attacks by checking duplicate external_id
 * - Monitor suspicious IP addresses
 * - Audit trail for compliance
 */
class WebhookLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'event_type',
        'external_id',
        'payload',
        'headers',
        'ip_address',
        'user_agent',
        'status',
        'error_message',
        'processed_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'headers' => 'array',
        'processed_at' => 'datetime',
    ];

    /**
     * Scope successful webhooks
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    /**
     * Scope failed webhooks
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope invalid webhooks (security threats)
     */
    public function scopeInvalid($query)
    {
        return $query->where('status', 'invalid');
    }

    /**
     * Scope by source
     */
    public function scopeFromSource($query, string $source)
    {
        return $query->where('source', $source);
    }

    /**
     * Check if this external_id was already processed
     * (Detect replay attacks)
     */
    public static function isReplayAttack(string $externalId, string $source): bool
    {
        return static::where('external_id', $externalId)
            ->where('source', $source)
            ->where('status', 'success')
            ->exists();
    }
}
