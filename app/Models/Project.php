<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }

    /** Active projects whose city or type matches the URL segment. */
    public function scopeListing(Builder $query, string $segment): Builder
    {
        return $query->where('status', 'active')
            ->where(fn ($q) => $q->where('city', $segment)->orWhere('type', $segment));
    }
}
