<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partnership_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('business_name');
            $table->string('phone');
            $table->string('city');
            $table->string('partner_type');
            $table->string('estimated_need');
            $table->text('message')->nullable();
            $table->string('status')->default('new');
            $table->timestamp('contacted_at')->nullable();
            $table->string('source_url', 2048)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partnership_inquiries');
    }
};
