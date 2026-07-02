<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CareerPosition;
use App\Models\NewsArticle;
use App\Models\SiteSetting;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function newsIndex(): View
    {
        return view('frontend.news-index', [
            'siteSetting' => SiteSetting::query()->first(),
            'articles' => NewsArticle::query()
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('published_at')->orWhere('published_at', '<=', now());
                })
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->orderByDesc('published_at')
                ->paginate(9),
        ]);
    }

    public function news(NewsArticle $newsArticle): View
    {
        abort_unless($newsArticle->is_active, 404);
        abort_if($newsArticle->published_at && $newsArticle->published_at->isFuture(), 404);

        return view('frontend.news-detail', [
            'siteSetting' => SiteSetting::query()->first(),
            'article' => $newsArticle,
            'relatedArticles' => NewsArticle::query()
                ->where('is_active', true)
                ->where('id', '!=', $newsArticle->id)
                ->where(fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()))
                ->orderByDesc('is_featured')
                ->orderByDesc('published_at')
                ->take(3)
                ->get(),
        ]);
    }

    public function careersIndex(): View
    {
        return view('frontend.careers-index', [
            'siteSetting' => SiteSetting::query()->first(),
            'careers' => CareerPosition::query()
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('closes_at')->orWhere('closes_at', '>=', now()->toDateString());
                })
                ->orderBy('sort_order')
                ->orderByDesc('created_at')
                ->paginate(9),
        ]);
    }

    public function career(CareerPosition $careerPosition): View
    {
        abort_unless($careerPosition->is_active, 404);
        abort_if($careerPosition->closes_at && $careerPosition->closes_at->lt(now()->toDateString()), 404);

        return view('frontend.career-detail', [
            'siteSetting' => SiteSetting::query()->first(),
            'career' => $careerPosition,
            'relatedCareers' => CareerPosition::query()
                ->where('is_active', true)
                ->where('id', '!=', $careerPosition->id)
                ->where(function ($query) {
                    $query->whereNull('closes_at')->orWhere('closes_at', '>=', now()->toDateString());
                })
                ->orderBy('sort_order')
                ->orderByDesc('created_at')
                ->take(3)
                ->get(),
        ]);
    }
}
