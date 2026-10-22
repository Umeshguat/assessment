<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', fn (Blueprint $t) => $t->index(['status', 'city', 'bhk', 'type'], 'projects_listing_idx'));
        Schema::table('landing_pages', fn (Blueprint $t) => $t->unique('slug'));
        Schema::table('redirects', fn (Blueprint $t) => $t->unique('old_path'));
    }

    public function down(): void
    {
        Schema::table('projects', fn (Blueprint $t) => $t->dropIndex('projects_listing_idx'));
        Schema::table('landing_pages', fn (Blueprint $t) => $t->dropUnique(['slug']));
        Schema::table('redirects', fn (Blueprint $t) => $t->dropUnique(['old_path']));
    }
};
