<?php

namespace App\Services;

use App\Models\Redirect;
use Illuminate\Support\Facades\Cache;

class RedirectResolver
{
    public const KEY = 'redirects.map';

    public static function normalize(string $path): string
    {
        return '/' . trim(strtolower(rawurldecode(parse_url($path, PHP_URL_PATH) ?: '/')), '/');
    }

    public static function flush(): void
    {
        Cache::forget(self::KEY);
    }

    public function resolve(string $path): ?array
    {
        $map = Cache::remember(self::KEY, 86400, fn () => Redirect::query()
            ->get(['id', 'old_path', 'new_path', 'status_code'])
            ->mapWithKeys(fn ($r) => [self::normalize($r->old_path) => ['id' => $r->id, 'to' => $r->new_path, 'code' => (int) $r->status_code]])
            ->all());

        $hit = $map[self::normalize($path)] ?? null;
        if (! $hit) {
            return null;
        }

        $seen = [self::normalize($path)];
        while ($hit['code'] !== 410 && isset($map[$next = self::normalize($hit['to'])]) && ! in_array($next, $seen, true) && count($seen) < 5) {
            $seen[] = $next;
            $hit = ['id' => $hit['id']] + $map[$next];
        }

        return $hit;
    }
}
