<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Traits\Auditable;
use App\Traits\HasSlug;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasSlug, Auditable;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'tags',
        'status',
        'views_count',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'views_count' => 'integer',
        'published_at' => 'datetime',
        'status' => PublishStatus::class,
    ];

    protected $slugSource = 'title';

    /**
     * Scope published articles
     */
    public function scopePublished($query)
    {
        return $query->where('status', PublishStatus::PUBLISHED->value)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope recent articles
     */
    public function scopeRecent($query, int $limit = 5)
    {
        return $query->published()
            ->orderBy('published_at', 'desc')
            ->limit($limit);
    }

    /**
     * Increment views count
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    /**
     * Check if article is published
     */
    public function isPublished(): bool
    {
        return $this->status === PublishStatus::PUBLISHED 
            && $this->published_at 
            && $this->published_at->isPast();
    }
}
