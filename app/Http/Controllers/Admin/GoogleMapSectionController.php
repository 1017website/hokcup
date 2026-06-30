<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoogleMapSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GoogleMapSectionController extends Controller
{
    public function edit(): View
    {
        return view('admin.google-map.edit', [
            'map' => GoogleMapSection::firstOrCreate([], [
                'eyebrow_icon' => 'fa-location-dot',
                'eyebrow_text' => 'Lokasi Kami',
                'title' => 'Temukan Hok Cup di Google Maps',
                'button_text' => 'Buka Google Maps',
                'is_active' => true,
            ]),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $map = GoogleMapSection::firstOrCreate([], ['title' => 'Temukan Hok Cup di Google Maps']);

        $data = $request->validate([
            'eyebrow_icon' => ['nullable', 'string', 'max:80'],
            'eyebrow_text' => ['nullable', 'string', 'max:150'],
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'embed_code' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:120'],
            'button_url' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $map->update($data);

        return back()->with('success', 'Google Maps berhasil diperbarui.');
    }
}
