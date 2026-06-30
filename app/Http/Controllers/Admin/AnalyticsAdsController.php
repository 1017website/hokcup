<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnalyticsAdsController extends Controller
{
    public function edit(): View
    {
        return view('admin.analytics-ads.edit', [
            'setting' => SiteSetting::firstOrCreate([], ['site_name' => 'Hok Cup']),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $setting = SiteSetting::firstOrCreate([], ['site_name' => 'Hok Cup']);

        $data = $request->validate([
            'google_analytics_id' => ['nullable', 'string', 'max:80'],
            'google_tag_manager_id' => ['nullable', 'string', 'max:80'],
            'meta_pixel_id' => ['nullable', 'string', 'max:80'],
            'google_ads_id' => ['nullable', 'string', 'max:80'],
            'google_ads_conversion_label' => ['nullable', 'string', 'max:120'],
            'head_scripts' => ['nullable', 'string'],
            'body_start_scripts' => ['nullable', 'string'],
            'body_end_scripts' => ['nullable', 'string'],
        ]);

        $setting->update($data);

        return back()->with('success', 'Analytics dan Ads berhasil diperbarui.');
    }
}
