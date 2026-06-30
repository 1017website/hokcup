<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialWidget;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SocialWidgetController extends Controller
{
    public function index(): View
    {
        return view('admin.social-widgets.index', ['widgets' => SocialWidget::orderBy('sort_order')->get()]);
    }
    public function create(): View
    {
        return view('admin.social-widgets.form', ['widget' => new SocialWidget(), 'mode' => 'create']);
    }
    public function store(Request $request): RedirectResponse
    {
        SocialWidget::create($this->validatedData($request));
        return redirect()->route('admin.social-widgets.index')->with('success','Widget berhasil dibuat.');
    }
    public function edit(SocialWidget $socialWidget): View
    {
        return view('admin.social-widgets.form', ['widget' => $socialWidget, 'mode' => 'edit']);
    }
    public function update(Request $request, SocialWidget $socialWidget): RedirectResponse
    {
        $socialWidget->update($this->validatedData($request));
        return redirect()->route('admin.social-widgets.index')->with('success','Widget berhasil diperbarui.');
    }
    public function destroy(SocialWidget $socialWidget): RedirectResponse
    {
        $socialWidget->delete();
        return back()->with('success','Widget berhasil dihapus.');
    }
    protected function validatedData(Request $request): array
    {
        $data = $request->validate([
            'icon' => ['required','string','max:80'],
            'title' => ['required','string','max:150'],
            'description' => ['nullable','string'],
            'embed_code' => ['nullable','string'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_active' => ['nullable','boolean'],
        ]);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');
        return $data;
    }
}
