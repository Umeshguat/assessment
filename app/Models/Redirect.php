<?php

namespace App\Models;

use App\Services\RedirectResolver;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    public $timestamps = false;

    protected $fillable = ['old_path', 'new_path', 'status_code', 'hits'];

    protected static function booted(): void
    {
        static::saved(fn () => RedirectResolver::flush());
        static::deleted(fn () => RedirectResolver::flush());
    }
}
