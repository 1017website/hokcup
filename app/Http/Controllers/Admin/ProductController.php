<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Support\HokCupUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::with(['category','specs'])->orderBy('sort_order')->orderBy('name')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.form', ['product' => new Product(), 'categories' => Category::orderBy('sort_order')->get(), 'mode' => 'create']);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['image'] = HokCupUploader::store($request->file('image_file'), $data['image'] ?? null, 'hokcup/products');
        $product = Product::create($data);
        $this->syncSpecs($product, $request);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dibuat.');
    }

    public function edit(Product $product): View
    {
        $product->load('specs');
        return view('admin.products.form', ['product' => $product, 'categories' => Category::orderBy('sort_order')->get(), 'mode' => 'edit']);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validatedData($request, $product->id);
        $data['image'] = HokCupUploader::store($request->file('image_file'), $data['image'] ?? $product->image, 'hokcup/products');
        $product->update($data);
        $this->syncSpecs($product, $request);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    protected function validatedData(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'name' => ['required','string','max:180'],
            'slug' => ['nullable','string','max:200', Rule::unique('products', 'slug')->ignore($ignoreId)],
            'size' => ['nullable','integer','min:0'],
            'image' => ['nullable','string','max:2048'],
            'image_file' => ['nullable','image','max:4096'],
            'label' => ['nullable','string','max:80'],
            'description' => ['required','string'],
            'is_featured' => ['nullable','boolean'],
            'is_active' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);
        unset($data['image_file']);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['size'] = $data['size'] ?? 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        return $data;
    }

    protected function syncSpecs(Product $product, Request $request): void
    {
        $product->specs()->delete();
        foreach ($request->input('spec_keys', []) as $index => $key) {
            $value = $request->input("spec_values.$index");
            if (!trim((string)$key) || !trim((string)$value)) continue;
            $product->specs()->create([
                'spec_key' => $key,
                'spec_value' => $value,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
