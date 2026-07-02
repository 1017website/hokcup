<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('news_articles')) {
            Schema::create('news_articles', function (Blueprint $table) {
                $table->id();
                $table->string('title', 220);
                $table->string('slug', 240)->unique();
                $table->string('image', 2048)->nullable();
                $table->string('author', 120)->nullable();
                $table->text('excerpt')->nullable();
                $table->longText('content')->nullable();
                $table->timestamp('published_at')->nullable()->index();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_featured')->default(false);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('career_positions')) {
            Schema::create('career_positions', function (Blueprint $table) {
                $table->id();
                $table->string('title', 220);
                $table->string('slug', 240)->unique();
                $table->string('department', 160)->nullable();
                $table->string('location', 180)->nullable();
                $table->string('employment_type', 120)->nullable();
                $table->string('work_type', 120)->nullable();
                $table->string('salary_range', 160)->nullable();
                $table->text('summary')->nullable();
                $table->longText('description')->nullable();
                $table->longText('requirements')->nullable();
                $table->string('apply_url', 500)->nullable();
                $table->string('apply_email', 180)->nullable();
                $table->date('closes_at')->nullable()->index();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('career_positions');
        Schema::dropIfExists('news_articles');
    }
};
