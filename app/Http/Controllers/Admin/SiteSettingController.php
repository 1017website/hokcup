<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\HokCupUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.site-settings.edit', ['setting' => SiteSetting::firstOrCreate([], ['site_name' => 'Hok Cup'])]);
    }

    public function update(Request $request): RedirectResponse
    {
        $setting = SiteSetting::firstOrCreate([], ['site_name' => 'Hok Cup']);
        $data = $request->validate([
            'site_name' => ['required','string','max:150'],
            'brand_tagline' => ['nullable','string','max:150'],
            'logo' => ['nullable','string','max:2048'],
            'logo_file' => ['nullable','image','max:4096'],
            'favicon' => ['nullable','string','max:2048'],
            'favicon_file' => ['nullable','image','max:2048'],
            'whatsapp_number' => ['required','string','max:30'],
            'email' => ['nullable','email','max:150'],
            'operational_hours' => ['nullable','string','max:150'],
            'meta_title' => ['nullable','string','max:180'],
            'meta_description' => ['nullable','string','max:500'],
            'meta_keywords' => ['nullable','string','max:500'],
            'og_image' => ['nullable','string','max:2048'],
            'og_image_file' => ['nullable','image','max:4096'],
        ]);
        unset($data['logo_file'], $data['favicon_file'], $data['og_image_file']);
        $data['logo'] = HokCupUploader::store($request->file('logo_file'), $data['logo'] ?? $setting->logo, 'hokcup/settings');
        $data['favicon'] = HokCupUploader::store($request->file('favicon_file'), $data['favicon'] ?? $setting->favicon, 'hokcup/settings');
        $data['og_image'] = HokCupUploader::store($request->file('og_image_file'), $data['og_image'] ?? $setting->og_image, 'hokcup/settings');
        $setting->update($data);
        return back()->with('success', 'Pengaturan website berhasil diperbarui.');
    }
}
