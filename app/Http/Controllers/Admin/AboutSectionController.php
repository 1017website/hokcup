<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use App\Models\AboutStat;
use App\Support\HokCupUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutSectionController extends Controller
{
    public function edit(): View
    {
        return view('admin.about.edit', [
            'about' => AboutSection::firstOrCreate([], ['title' => 'Tentang Hok Cup']),
            'stats' => AboutStat::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $about = AboutSection::firstOrCreate([], ['title' => 'Tentang Hok Cup']);
        $data = $request->validate([
            'eyebrow_icon' => ['nullable','string','max:80'],
            'eyebrow_text' => ['required','string','max:150'],
            'title' => ['required','string','max:180'],
            'description' => ['required','string'],
            'image' => ['nullable','string','max:2048'],
            'image_file' => ['nullable','image','max:4096'],
            'stat_number' => ['array'],
            'stat_label' => ['array'],
            'stat_active' => ['array'],
        ]);
        unset($data['image_file'], $data['stat_number'], $data['stat_label'], $data['stat_active']);
        $data['image'] = HokCupUploader::store($request->file('image_file'), $data['image'] ?? $about->image, 'hokcup/about');
        $about->update($data);

        AboutStat::query()->delete();
        foreach ($request->input('stat_number', []) as $index => $number) {
            $label = $request->input("stat_label.$index");
            if (!trim((string)$number) || !trim((string)$label)) continue;
            AboutStat::create([
                'number' => $number,
                'label' => $label,
                'sort_order' => $index + 1,
                'is_active' => $request->boolean("stat_active.$index"),
            ]);
        }

        return back()->with('success','Tentang berhasil diperbarui.');
    }
}
