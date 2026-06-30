<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('visitor_logs')) {
            Schema::create('visitor_logs', function (Blueprint $table) {
                $table->id();
                $table->string('session_id', 120)->nullable()->index();
                $table->string('visitor_hash', 100)->index();
                $table->string('ip_hash', 100)->nullable()->index();
                $table->text('user_agent')->nullable();
                $table->string('url', 2048)->nullable();
                $table->string('path', 255)->nullable()->index();
                $table->string('referer', 2048)->nullable();
                $table->string('source', 160)->nullable()->index();
                $table->string('device', 40)->nullable()->index();
                $table->string('browser', 80)->nullable();
                $table->timestamp('created_at')->useCurrent()->index();
            });
        }

        Schema::table('site_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('site_settings', 'seo_robots')) {
                $table->string('seo_robots', 120)->nullable()->after('meta_keywords');
            }
            if (!Schema::hasColumn('site_settings', 'canonical_url')) {
                $table->string('canonical_url', 500)->nullable()->after('seo_robots');
            }
            if (!Schema::hasColumn('site_settings', 'twitter_title')) {
                $table->string('twitter_title', 180)->nullable()->after('canonical_url');
            }
            if (!Schema::hasColumn('site_settings', 'twitter_description')) {
                $table->text('twitter_description')->nullable()->after('twitter_title');
            }
            if (!Schema::hasColumn('site_settings', 'twitter_image')) {
                $table->string('twitter_image', 500)->nullable()->after('twitter_description');
            }
            if (!Schema::hasColumn('site_settings', 'schema_json_ld')) {
                $table->longText('schema_json_ld')->nullable()->after('twitter_image');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');

        Schema::table('site_settings', function (Blueprint $table) {
            foreach ([
                'schema_json_ld',
                'twitter_image',
                'twitter_description',
                'twitter_title',
                'canonical_url',
                'seo_robots',
            ] as $column) {
                if (Schema::hasColumn('site_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
