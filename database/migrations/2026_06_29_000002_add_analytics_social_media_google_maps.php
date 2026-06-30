<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('site_settings', 'google_analytics_id')) {
                $table->string('google_analytics_id', 80)->nullable()->after('og_image');
            }
            if (!Schema::hasColumn('site_settings', 'google_tag_manager_id')) {
                $table->string('google_tag_manager_id', 80)->nullable()->after('google_analytics_id');
            }
            if (!Schema::hasColumn('site_settings', 'meta_pixel_id')) {
                $table->string('meta_pixel_id', 80)->nullable()->after('google_tag_manager_id');
            }
            if (!Schema::hasColumn('site_settings', 'google_ads_id')) {
                $table->string('google_ads_id', 80)->nullable()->after('meta_pixel_id');
            }
            if (!Schema::hasColumn('site_settings', 'google_ads_conversion_label')) {
                $table->string('google_ads_conversion_label', 120)->nullable()->after('google_ads_id');
            }
            if (!Schema::hasColumn('site_settings', 'head_scripts')) {
                $table->longText('head_scripts')->nullable()->after('google_ads_conversion_label');
            }
            if (!Schema::hasColumn('site_settings', 'body_start_scripts')) {
                $table->longText('body_start_scripts')->nullable()->after('head_scripts');
            }
            if (!Schema::hasColumn('site_settings', 'body_end_scripts')) {
                $table->longText('body_end_scripts')->nullable()->after('body_start_scripts');
            }
        });

        if (!Schema::hasTable('social_media_links')) {
            Schema::create('social_media_links', function (Blueprint $table) {
                $table->id();
                $table->string('platform', 120);
                $table->string('label', 160)->nullable();
                $table->string('icon', 120)->default('fas fa-link');
                $table->string('url', 500);
                $table->string('username', 160)->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('google_map_sections')) {
            Schema::create('google_map_sections', function (Blueprint $table) {
                $table->id();
                $table->string('eyebrow_icon', 80)->nullable();
                $table->string('eyebrow_text', 150)->nullable();
                $table->string('title', 180);
                $table->text('description')->nullable();
                $table->text('address')->nullable();
                $table->longText('embed_code')->nullable();
                $table->string('button_text', 120)->nullable();
                $table->string('button_url', 500)->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('google_map_sections');
        Schema::dropIfExists('social_media_links');

        Schema::table('site_settings', function (Blueprint $table) {
            foreach ([
                'body_end_scripts',
                'body_start_scripts',
                'head_scripts',
                'google_ads_conversion_label',
                'google_ads_id',
                'meta_pixel_id',
                'google_tag_manager_id',
                'google_analytics_id',
            ] as $column) {
                if (Schema::hasColumn('site_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
