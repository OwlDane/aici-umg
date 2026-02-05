<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\HasSlug;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasSlug, Auditable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'quantity',
        'image',
        'specifications',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'specifications' => 'array',
        'quantity' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $slugSource = 'name';

    /**
     * Scope active facilities
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by type
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope ordered
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
