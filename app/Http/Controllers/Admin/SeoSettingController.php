<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\HokCupUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SeoSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.seo.edit', [
            'setting' => SiteSetting::firstOrCreate([], ['site_name' => 'Hok Cup']),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $setting = SiteSetting::firstOrCreate([], ['site_name' => 'Hok Cup']);

        $data = $request->validate([
            'meta_title' => ['nullable', 'string', 'max:180'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'seo_robots' => ['nullable', 'string', 'max:120', Rule::in(['index, follow', 'noindex, follow', 'index, nofollow', 'noindex, nofollow'])],
            'canonical_url' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'string', 'max:2048'],
            'og_image_file' => ['nullable', 'image', 'max:4096'],
            'twitter_title' => ['nullable', 'string', 'max:180'],
            'twitter_description' => ['nullable', 'string', 'max:500'],
            'twitter_image' => ['nullable', 'string', 'max:2048'],
            'twitter_image_file' => ['nullable', 'image', 'max:4096'],
            'schema_json_ld' => ['nullable', 'json'],
        ]);

        unset($data['og_image_file'], $data['twitter_image_file']);
        $data['og_image'] = HokCupUploader::store($request->file('og_image_file'), $data['og_image'] ?? $setting->og_image, 'hokcup/settings');
        $data['twitter_image'] = HokCupUploader::store($request->file('twitter_image_file'), $data['twitter_image'] ?? $setting->twitter_image, 'hokcup/settings');

        $setting->update($data);

        return back()->with('success', 'SEO berhasil diperbarui.');
    }
}
