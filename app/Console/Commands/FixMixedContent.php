<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixMixedContent extends Command
{
    protected $signature = 'content:fix-mixed {--dry-run : Report only, write nothing} {--chunk=200}';
    protected $description = 'Rewrite http:// src/href/srcset/poster/url() to https:// in developers.description and projects.description';

    private const TABLES = ['developers', 'projects'];

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');
        $chunk = max(1, (int) $this->option('chunk'));
        $total = 0;

        foreach (self::TABLES as $table) {
            $changed = 0;

            DB::table($table)
                ->select('id', 'description')
                ->where('description', 'like', '%http://%')
                ->chunkById($chunk, function ($rows) use ($table, $dry, &$changed) {
                    foreach ($rows as $row) {
                        $new = $this->fix((string) $row->description);
                        if ($new === $row->description) {
                            continue;
                        }
                        $changed++;
                        if (! $dry) {
                            DB::table($table)->where('id', $row->id)->update(['description' => $new]);
                        }
                    }
                });

            $this->line(sprintf('%-11s %d record(s) %s', $table, $changed, $dry ? 'would change' : 'changed'));
            $total += $changed;
        }

        $this->info(sprintf('%s: %d record(s) %s.', $dry ? 'DRY RUN' : 'DONE', $total, $dry ? 'would be changed' : 'changed'));

        return self::SUCCESS;
    }

    private function fix(string $html): string
    {
        $html = preg_replace('/\b(src|href|poster|data-src|data-lazy-src)(\s*=\s*)(["\'])http:\/\//i', '$1$2$3https://', $html);

        $html = preg_replace_callback(
            '/\bsrcset\s*=\s*(["\'])(.*?)\1/is',
            fn ($m) => 'srcset=' . $m[1] . str_replace('http://', 'https://', $m[2]) . $m[1],
            $html
        );

        return preg_replace('/url\(\s*(["\']?)http:\/\//i', 'url($1https://', $html);
    }
}
