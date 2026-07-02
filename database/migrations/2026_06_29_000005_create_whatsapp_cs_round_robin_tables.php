<?php

use App\Models\WhatsappCustomerService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('whatsapp_customer_services')) {
            Schema::create('whatsapp_customer_services', function (Blueprint $table) {
                $table->id();
                $table->string('name', 120);
                $table->string('phone_number', 30);
                $table->string('display_number', 60)->nullable();
                $table->text('greeting_message')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->unsignedInteger('total_clicks')->default(0);
                $table->boolean('is_active')->default(true)->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('whatsapp_click_logs')) {
            Schema::create('whatsapp_click_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('whatsapp_customer_service_id')->nullable()->constrained('whatsapp_customer_services')->nullOnDelete();
                $table->string('product_name', 180)->nullable();
                $table->text('message')->nullable();
                $table->string('ip_hash', 128)->nullable();
                $table->text('user_agent')->nullable();
                $table->text('referer')->nullable();
                $table->text('source_url')->nullable();
                $table->timestamps();

                $table->index('created_at');
            });
        }

        if (Schema::hasTable('whatsapp_customer_services') && DB::table('whatsapp_customer_services')->count() === 0) {
            $fallbackNumber = '6281234567890';
            $siteName = 'Website';

            if (Schema::hasTable('site_settings')) {
                $setting = DB::table('site_settings')->first();
                $fallbackNumber = WhatsappCustomerService::normalizePhone((string) ($setting->whatsapp_number ?? $fallbackNumber)) ?: $fallbackNumber;
                $siteName = (string) ($setting->site_name ?? $siteName);
            }

            DB::table('whatsapp_customer_services')->insert([
                'name' => 'CS Utama',
                'phone_number' => $fallbackNumber,
                'display_number' => WhatsappCustomerService::formatDisplayNumber($fallbackNumber),
                'greeting_message' => 'Halo ' . $siteName . ', saya ingin bertanya produk dan katalog harga.',
                'sort_order' => 1,
                'total_clicks' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_click_logs');
        Schema::dropIfExists('whatsapp_customer_services');
    }
};
