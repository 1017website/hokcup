<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Support\HokCupUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class NewsArticleController extends Controller
{
    public function index(): View
    {
        return view('admin.news.index', [
            'articles' => NewsArticle::query()
                ->orderByDesc('is_featured')
                ->orderByDesc('published_at')
                ->orderBy('sort_order')
                ->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.news.form', ['article' => new NewsArticle(), 'mode' => 'create']);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['image'] = HokCupUploader::store($request->file('image_file'), $data['image'] ?? null, 'hokcup/news');
        NewsArticle::create($data);

        return redirect()->route('admin.news.index')->with('success', 'News berhasil dibuat.');
    }

    public function edit(NewsArticle $newsArticle): View
    {
        return view('admin.news.form', ['article' => $newsArticle, 'mode' => 'edit']);
    }

    public function update(Request $request, NewsArticle $newsArticle): RedirectResponse
    {
        $data = $this->validatedData($request, $newsArticle->id);
        $data['image'] = HokCupUploader::store($request->file('image_file'), $data['image'] ?? $newsArticle->image, 'hokcup/news');
        $newsArticle->update($data);

        return redirect()->route('admin.news.index')->with('success', 'News berhasil diperbarui.');
    }

    public function destroy(NewsArticle $newsArticle): RedirectResponse
    {
        $newsArticle->delete();
        return back()->with('success', 'News berhasil dihapus.');
    }

    protected function validatedData(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:220'],
            'slug' => ['nullable', 'string', 'max:240', Rule::unique('news_articles', 'slug')->ignore($ignoreId)],
            'image' => ['nullable', 'string', 'max:2048'],
            'image_file' => ['nullable', 'image', 'max:4096'],
            'author' => ['nullable', 'string', 'max:120'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        unset($data['image_file']);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['published_at'] = $data['published_at'] ?: now();

        return $data;
    }
}
