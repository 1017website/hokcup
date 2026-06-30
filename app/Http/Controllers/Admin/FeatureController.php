<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeatureController extends Controller
{
    public function index(): View
    {
        return view('admin.features.index', ['features' => Feature::orderBy('sort_order')->get()]);
    }
    public function create(): View
    {
        return view('admin.features.form', ['feature' => new Feature(), 'mode' => 'create']);
    }
    public function store(Request $request): RedirectResponse
    {
        Feature::create($this->validatedData($request));
        return redirect()->route('admin.features.index')->with('success','Keunggulan berhasil dibuat.');
    }
    public function edit(Feature $feature): View
    {
        return view('admin.features.form', ['feature' => $feature, 'mode' => 'edit']);
    }
    public function update(Request $request, Feature $feature): RedirectResponse
    {
        $feature->update($this->validatedData($request));
        return redirect()->route('admin.features.index')->with('success','Keunggulan berhasil diperbarui.');
    }
    public function destroy(Feature $feature): RedirectResponse
    {
        $feature->delete();
        return back()->with('success','Keunggulan berhasil dihapus.');
    }
    protected function validatedData(Request $request): array
    {
        $data = $request->validate([
            'icon' => ['required','string','max:80'],
            'title' => ['required','string','max:150'],
            'description' => ['required','string'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_active' => ['nullable','boolean'],
        ]);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');
        return $data;
    }
}
