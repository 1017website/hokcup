<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Hok Cup');
            $table->string('brand_tagline')->nullable();
            $table->string('logo')->nullable();
            $table->string('whatsapp_number', 40)->nullable();
            $table->string('email')->nullable();
            $table->string('operational_hours')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
        });

        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow_icon')->nullable();
            $table->string('eyebrow_text');
            $table->string('title_before');
            $table->string('pill_word');
            $table->string('title_after');
            $table->text('description');
            $table->string('primary_button_text')->nullable();
            $table->string('primary_button_icon')->nullable();
            $table->string('secondary_button_text')->nullable();
            $table->string('secondary_button_icon')->nullable();
            $table->string('image')->nullable();
            $table->string('card_a_number')->nullable();
            $table->string('card_a_text')->nullable();
            $table->string('card_a_icon')->nullable();
            $table->string('card_b_number')->nullable();
            $table->string('card_b_text')->nullable();
            $table->string('card_b_icon')->nullable();
            $table->string('card_c_number')->nullable();
            $table->string('card_c_text')->nullable();
            $table->string('card_c_icon')->nullable();
            $table->timestamps();
        });

        Schema::create('hero_trust_items', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('text');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_name');
            $table->string('icon');
            $table->string('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('size')->default(0);
            $table->string('image')->nullable();
            $table->string('label')->nullable();
            $table->text('description');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('product_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('spec_key');
            $table->text('spec_value');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('title');
            $table->text('description');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow_icon')->nullable();
            $table->string('eyebrow_text')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('about_stats', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('label');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('social_widgets', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('embed_code')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('cta_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('button_text');
            $table->string('button_icon')->nullable();
            $table->text('whatsapp_message')->nullable();
            $table->timestamps();
        });

        Schema::create('footer_links', function (Blueprint $table) {
            $table->id();
            $table->string('group');
            $table->string('label');
            $table->string('url');
            $table->string('onclick')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_links');
        Schema::dropIfExists('cta_sections');
        Schema::dropIfExists('social_widgets');
        Schema::dropIfExists('about_stats');
        Schema::dropIfExists('about_sections');
        Schema::dropIfExists('features');
        Schema::dropIfExists('product_specs');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('hero_trust_items');
        Schema::dropIfExists('hero_sections');
        Schema::dropIfExists('site_settings');
    }
};
