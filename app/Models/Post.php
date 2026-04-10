<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'body',
        'pinned',
        'published_at',
    ];

    protected $casts = [
        'pinned'       => 'boolean',
        'published_at' => 'datetime',
    ];

    // --- Scopes ---
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopePinned($query)
    {
        return $query->where('pinned', true);
    }

    public function scopeAnnouncements($query)
    {
        return $query->where('type', 'announcement');
    }

    public function scopeReminders($query)
    {
        return $query->where('type', 'reminder');
    }

    // --- Relationships ---
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function views()
    {
        return $this->hasMany(PostView::class);
    }

    // --- Helpers ---
    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at->lte(now());
    }

    public function reactionSummary(): array
    {
        return $this->reactions()
            ->selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();
    }
}
