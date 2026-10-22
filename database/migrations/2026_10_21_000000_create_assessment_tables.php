<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('developers', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->longText('description')->nullable();
            $t->string('logo')->nullable();
            $t->timestamps();
        });

        Schema::create('projects', function (Blueprint $t) {
            $t->id();
            $t->foreignId('developer_id')->constrained();
            $t->string('title');
            $t->string('slug')->unique();
            $t->string('city');
            $t->string('type');
            $t->unsignedTinyInteger('bhk')->nullable();
            $t->unsignedBigInteger('price')->nullable();
            $t->string('rera_no')->nullable();
            $t->string('image')->nullable();
            $t->longText('description')->nullable();
            $t->string('status')->default('active');
            $t->timestamps();
        });

        Schema::create('landing_pages', function (Blueprint $t) {
            $t->id();
            $t->string('slug');
            $t->string('city');
            $t->unsignedTinyInteger('bhk')->nullable();
            $t->string('type')->nullable();
            $t->string('heading');
            $t->text('intro')->nullable();
            $t->string('meta_title')->nullable();
            $t->string('meta_description')->nullable();
        });

        Schema::create('faqs', function (Blueprint $t) {
            $t->id();
            $t->string('question');
            $t->text('answer');
        });

        Schema::create('redirects', function (Blueprint $t) {
            $t->id();
            $t->string('old_path');
            $t->string('new_path');
            $t->unsignedSmallInteger('status_code')->default(301);
            $t->unsignedBigInteger('hits')->default(0);
        });
    }

    public function down(): void
    {
        foreach (['redirects', 'faqs', 'landing_pages', 'projects', 'developers'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
