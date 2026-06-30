<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CtaSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CtaSectionController extends Controller
{
    public function edit(): View
    {
        return view('admin.cta.edit', ['cta' => CtaSection::firstOrCreate([], ['title' => 'Butuh Rekomendasi Ukuran Cup?'])]);
    }
    public function update(Request $request): RedirectResponse
    {
        $cta = CtaSection::firstOrCreate([], ['title' => 'Butuh Rekomendasi Ukuran Cup?']);
        $data = $request->validate([
            'title' => ['required','string','max:180'],
            'description' => ['required','string'],
            'button_text' => ['required','string','max:80'],
            'button_icon' => ['nullable','string','max:80'],
            'whatsapp_message' => ['required','string','max:500'],
        ]);
        $cta->update($data);
        return back()->with('success','CTA berhasil diperbarui.');
    }
}
