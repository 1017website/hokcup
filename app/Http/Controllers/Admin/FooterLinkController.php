<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FooterLinkController extends Controller
{
    public function index(): View
    {
        return view('admin.footer-links.index', ['links' => FooterLink::orderBy('group')->orderBy('sort_order')->get()]);
    }
    public function create(): View
    {
        return view('admin.footer-links.form', ['link' => new FooterLink(), 'mode' => 'create']);
    }
    public function store(Request $request): RedirectResponse
    {
        FooterLink::create($this->validatedData($request));
        return redirect()->route('admin.footer-links.index')->with('success','Link footer berhasil dibuat.');
    }
    public function edit(FooterLink $footerLink): View
    {
        return view('admin.footer-links.form', ['link' => $footerLink, 'mode' => 'edit']);
    }
    public function update(Request $request, FooterLink $footerLink): RedirectResponse
    {
        $footerLink->update($this->validatedData($request));
        return redirect()->route('admin.footer-links.index')->with('success','Link footer berhasil diperbarui.');
    }
    public function destroy(FooterLink $footerLink): RedirectResponse
    {
        $footerLink->delete();
        return back()->with('success','Link footer berhasil dihapus.');
    }
    protected function validatedData(Request $request): array
    {
        $data = $request->validate([
            'group' => ['required','string','max:80'],
            'label' => ['required','string','max:150'],
            'url' => ['required','string','max:500'],
            'onclick' => ['nullable','string','max:500'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_active' => ['nullable','boolean'],
        ]);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');
        return $data;
    }
}
