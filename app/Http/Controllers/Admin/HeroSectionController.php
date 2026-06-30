<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use App\Models\HeroTrustItem;
use App\Support\HokCupUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeroSectionController extends Controller
{
    public function edit(): View
    {
        return view('admin.hero.edit', [
            'hero' => HeroSection::firstOrCreate([], ['eyebrow_text' => 'Gelas Plastik Food Grade']),
            'trustItems' => HeroTrustItem::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $hero = HeroSection::firstOrCreate([], ['eyebrow_text' => 'Gelas Plastik Food Grade']);
        $data = $request->validate([
            'eyebrow_icon' => ['nullable','string','max:80'],
            'eyebrow_text' => ['required','string','max:150'],
            'title_before' => ['required','string','max:150'],
            'pill_word' => ['required','string','max:80'],
            'title_after' => ['required','string','max:150'],
            'description' => ['required','string'],
            'primary_button_text' => ['required','string','max:80'],
            'primary_button_icon' => ['nullable','string','max:80'],
            'secondary_button_text' => ['required','string','max:80'],
            'secondary_button_icon' => ['nullable','string','max:80'],
            'image' => ['nullable','string','max:2048'],
            'image_file' => ['nullable','image','max:4096'],
            'card_a_number' => ['nullable','string','max:50'],
            'card_a_text' => ['nullable','string','max:100'],
            'card_a_icon' => ['nullable','string','max:80'],
            'card_b_number' => ['nullable','string','max:50'],
            'card_b_text' => ['nullable','string','max:100'],
            'card_b_icon' => ['nullable','string','max:80'],
            'card_c_number' => ['nullable','string','max:50'],
            'card_c_text' => ['nullable','string','max:100'],
            'card_c_icon' => ['nullable','string','max:80'],
            'trust_text' => ['array'],
            'trust_icon' => ['array'],
            'trust_active' => ['array'],
        ]);
        unset($data['image_file'], $data['trust_text'], $data['trust_icon'], $data['trust_active']);
        $data['image'] = HokCupUploader::store($request->file('image_file'), $data['image'] ?? $hero->image, 'hokcup/hero');
        $hero->update($data);

        HeroTrustItem::query()->delete();
        foreach ($request->input('trust_text', []) as $index => $text) {
            if (!trim((string)$text)) continue;
            HeroTrustItem::create([
                'icon' => $request->input("trust_icon.$index", 'fa-check-circle'),
                'text' => $text,
                'sort_order' => $index + 1,
                'is_active' => $request->boolean("trust_active.$index"),
            ]);
        }

        return back()->with('success', 'Hero section berhasil diperbarui.');
    }
}
