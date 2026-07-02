<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerPosition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CareerPositionController extends Controller
{
    public function index(): View
    {
        return view('admin.careers.index', [
            'careers' => CareerPosition::query()
                ->orderBy('sort_order')
                ->orderBy('title')
                ->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.careers.form', ['career' => new CareerPosition(), 'mode' => 'create']);
    }

    public function store(Request $request): RedirectResponse
    {
        CareerPosition::create($this->validatedData($request));
        return redirect()->route('admin.careers.index')->with('success', 'Lowongan karir berhasil dibuat.');
    }

    public function edit(CareerPosition $careerPosition): View
    {
        return view('admin.careers.form', ['career' => $careerPosition, 'mode' => 'edit']);
    }

    public function update(Request $request, CareerPosition $careerPosition): RedirectResponse
    {
        $careerPosition->update($this->validatedData($request, $careerPosition->id));
        return redirect()->route('admin.careers.index')->with('success', 'Lowongan karir berhasil diperbarui.');
    }

    public function destroy(CareerPosition $careerPosition): RedirectResponse
    {
        $careerPosition->delete();
        return back()->with('success', 'Lowongan karir berhasil dihapus.');
    }

    protected function validatedData(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:220'],
            'slug' => ['nullable', 'string', 'max:240', Rule::unique('career_positions', 'slug')->ignore($ignoreId)],
            'department' => ['nullable', 'string', 'max:160'],
            'location' => ['nullable', 'string', 'max:180'],
            'employment_type' => ['nullable', 'string', 'max:120'],
            'work_type' => ['nullable', 'string', 'max:120'],
            'salary_range' => ['nullable', 'string', 'max:160'],
            'summary' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'apply_url' => ['nullable', 'string', 'max:500'],
            'apply_email' => ['nullable', 'email', 'max:180'],
            'closes_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
