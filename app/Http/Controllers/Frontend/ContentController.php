<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CareerPosition;
use App\Models\NewsArticle;
use App\Models\SiteSetting;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function news(NewsArticle $newsArticle): View
    {
        abort_unless($newsArticle->is_active, 404);

        return view('frontend.news-detail', [
            'siteSetting' => SiteSetting::query()->first(),
            'article' => $newsArticle,
            'relatedArticles' => NewsArticle::query()
                ->where('is_active', true)
                ->where('id', '!=', $newsArticle->id)
                ->where(fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()))
                ->orderByDesc('published_at')
                ->take(3)
                ->get(),
        ]);
    }

    public function career(CareerPosition $careerPosition): View
    {
        abort_unless($careerPosition->is_active, 404);

        return view('frontend.career-detail', [
            'siteSetting' => SiteSetting::query()->first(),
            'career' => $careerPosition,
        ]);
    }
}
