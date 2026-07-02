<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhatsappClickLog;
use App\Models\WhatsappCustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WhatsappCustomerServiceController extends Controller
{
    public function index(): View
    {
        $services = WhatsappCustomerService::query()
            ->withCount([
                'clickLogs as clicks_30_days_count' => fn ($query) => $query->where('created_at', '>=', now()->subDays(30)),
                'clickLogs as clicks_today_count' => fn ($query) => $query->whereDate('created_at', today()),
            ])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $totalClicks = (int) $services->sum('total_clicks');
        $activeCount = (int) $services->where('is_active', true)->count();
        $clicks30Days = (int) $services->sum('clicks_30_days_count');
        $clicksToday = (int) $services->sum('clicks_today_count');

        return view('admin.whatsapp-cs.index', compact(
            'services',
            'totalClicks',
            'activeCount',
            'clicks30Days',
            'clicksToday'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['total_clicks'] = 0;

        WhatsappCustomerService::create($data);

        return back()->with('success', 'CS WhatsApp berhasil ditambahkan.');
    }

    public function update(Request $request, WhatsappCustomerService $whatsappCs): RedirectResponse
    {
        $whatsappCs->update($this->validatedData($request));

        return back()->with('success', 'CS WhatsApp berhasil diperbarui.');
    }

    public function destroy(WhatsappCustomerService $whatsappCs): RedirectResponse
    {
        $whatsappCs->delete();

        return back()->with('success', 'CS WhatsApp berhasil dihapus.');
    }

    public function resetStats(): RedirectResponse
    {
        DB::transaction(function () {
            WhatsappClickLog::query()->delete();
            WhatsappCustomerService::query()->update(['total_clicks' => 0]);
        });

        return back()->with('success', 'Statistik click WhatsApp berhasil direset.');
    }

    protected function validatedData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone_number' => ['required', 'string', 'max:30'],
            'display_number' => ['nullable', 'string', 'max:60'],
            'greeting_message' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['phone_number'] = WhatsappCustomerService::normalizePhone((string) $data['phone_number']);
        $data['display_number'] = $data['display_number'] ?: WhatsappCustomerService::formatDisplayNumber($data['phone_number']);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
