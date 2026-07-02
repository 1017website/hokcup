<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\WhatsappClickLog;
use App\Models\WhatsappCustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WhatsappRedirectController extends Controller
{
    public function redirect(Request $request): RedirectResponse
    {
        [$number, $message] = DB::transaction(function () use ($request) {
            $service = WhatsappCustomerService::query()
                ->active()
                ->orderBy('total_clicks')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->lockForUpdate()
                ->first();

            $siteSetting = SiteSetting::query()->first();
            $siteName = $siteSetting?->site_name ?: 'Website';
            $productName = trim((string) $request->query('product', ''));

            $message = trim((string) $request->query('text', ''));

            if (! $message && $service?->greeting_message) {
                $message = $service->greeting_message;
            }

            if (! $message) {
                $message = 'Halo ' . $siteName . ', saya ingin bertanya produk dan katalog harga.';
            }

            if ($productName && ! Str::contains(Str::lower($message), Str::lower($productName))) {
                $message .= "\n\nProduk: " . $productName;
            }

            if ($service) {
                $service->increment('total_clicks');

                WhatsappClickLog::create([
                    'whatsapp_customer_service_id' => $service->id,
                    'product_name' => $productName ?: null,
                    'message' => Str::limit($message, 2000, ''),
                    'ip_hash' => $request->ip() ? hash('sha256', $request->ip()) : null,
                    'user_agent' => Str::limit((string) $request->userAgent(), 1000, ''),
                    'referer' => Str::limit((string) $request->headers->get('referer'), 2048, ''),
                    'source_url' => Str::limit((string) $request->fullUrl(), 2048, ''),
                ]);

                return [$service->phone_number, $message];
            }

            $fallbackNumber = WhatsappCustomerService::normalizePhone((string) ($siteSetting?->whatsapp_number ?: '6281234567890'));

            return [$fallbackNumber, $message];
        });

        $number = WhatsappCustomerService::normalizePhone($number);
        $url = 'https://wa.me/' . $number . '?text=' . rawurlencode($message);

        return redirect()->away($url);
    }
}
