<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMediaLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SocialMediaLinkController extends Controller
{
    public function index(): View
    {
        return view('admin.social-media-links.index', [
            'links' => SocialMediaLink::orderBy('sort_order')->orderBy('platform')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.social-media-links.form', ['link' => new SocialMediaLink(), 'mode' => 'create']);
    }

    public function store(Request $request): RedirectResponse
    {
        SocialMediaLink::create($this->validatedData($request));
        return redirect()->route('admin.social-media-links.index')->with('success', 'Sosial media berhasil dibuat.');
    }

    public function edit(SocialMediaLink $socialMediaLink): View
    {
        return view('admin.social-media-links.form', ['link' => $socialMediaLink, 'mode' => 'edit']);
    }

    public function update(Request $request, SocialMediaLink $socialMediaLink): RedirectResponse
    {
        $socialMediaLink->update($this->validatedData($request));
        return redirect()->route('admin.social-media-links.index')->with('success', 'Sosial media berhasil diperbarui.');
    }

    public function destroy(SocialMediaLink $socialMediaLink): RedirectResponse
    {
        $socialMediaLink->delete();
        return back()->with('success', 'Sosial media berhasil dihapus.');
    }

    protected function validatedData(Request $request): array
    {
        $data = $request->validate([
            'platform' => ['required', 'string', 'max:120'],
            'label' => ['nullable', 'string', 'max:160'],
            'icon' => ['required', 'string', 'max:120'],
            'url' => ['required', 'string', 'max:500'],
            'username' => ['nullable', 'string', 'max:160'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
