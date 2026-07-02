<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use App\Models\AboutStat;
use App\Models\CareerPosition;
use App\Models\Category;
use App\Models\CtaSection;
use App\Models\Feature;
use App\Models\FooterLink;
use App\Models\GoogleMapSection;
use App\Models\HeroSection;
use App\Models\HeroTrustItem;
use App\Models\NewsArticle;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\SocialMediaLink;
use App\Models\SocialWidget;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $this->trackVisitor($request);

        $siteSetting = SiteSetting::query()->first();
        $hero = HeroSection::query()->first();
        $trustItems = HeroTrustItem::query()->where('is_active', true)->orderBy('sort_order')->get();

        $categories = Category::query()
            ->where('is_active', true)
            ->withCount(['products' => fn ($query) => $query->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();

        $products = Product::query()
            ->where('is_active', true)
            ->with(['category', 'specs'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $frontendCategories = collect([
            ['id' => 'all', 'name' => 'Semua Produk', 'short' => 'All', 'icon' => 'fa-border-all', 'desc' => 'Tampilkan seluruh katalog', 'count' => $products->count()],
        ])->merge($categories->map(fn ($category) => $category->toFrontendArray((int) $category->products_count)))->values();

        return view('frontend.home', [
            'siteSetting' => $siteSetting,
            'hero' => $hero,
            'trustItems' => $trustItems,
            'categories' => $categories,
            'frontendCategories' => $frontendCategories,
            'frontendProducts' => $products->map(fn ($product) => $product->toFrontendArray())->values(),
            'features' => Feature::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'about' => AboutSection::query()->first(),
            'aboutStats' => AboutStat::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'socialWidgets' => SocialWidget::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'socialLinks' => SocialMediaLink::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'newsArticles' => NewsArticle::query()
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('published_at')->orWhere('published_at', '<=', now());
                })
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->orderByDesc('published_at')
                ->limit(3)
                ->get(),
            'careerPositions' => CareerPosition::query()
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('closes_at')->orWhere('closes_at', '>=', now()->toDateString());
                })
                ->orderBy('sort_order')
                ->orderByDesc('created_at')
                ->limit(3)
                ->get(),
            'googleMap' => GoogleMapSection::query()->where('is_active', true)->first(),
            'cta' => CtaSection::query()->first(),
            'footerLinks' => FooterLink::query()->where('is_active', true)->orderBy('sort_order')->get()->groupBy('group'),
        ]);
    }

    protected function trackVisitor(Request $request): void
    {
        if ($this->isLikelyBot((string) $request->userAgent())) {
            return;
        }

        $visitorId = $request->cookie('hokcup_visitor_id');
        if (!$visitorId) {
            $visitorId = (string) Str::uuid();
            Cookie::queue(cookie('hokcup_visitor_id', $visitorId, 60 * 24 * 365));
        }

        VisitorLog::create([
            'session_id' => $request->session()->getId(),
            'visitor_hash' => hash('sha256', $visitorId),
            'ip_hash' => $request->ip() ? hash('sha256', $request->ip()) : null,
            'user_agent' => Str::limit((string) $request->userAgent(), 1000, ''),
            'url' => Str::limit($request->fullUrl(), 2048, ''),
            'path' => Str::limit('/' . ltrim($request->path(), '/'), 255, ''),
            'referer' => Str::limit((string) $request->headers->get('referer'), 2048, ''),
            'source' => $this->detectSource((string) $request->headers->get('referer')),
            'device' => $this->detectDevice((string) $request->userAgent()),
            'browser' => $this->detectBrowser((string) $request->userAgent()),
            'created_at' => now(),
        ]);
    }

    protected function detectSource(string $referer): string
    {
        if (!$referer) {
            return 'Direct';
        }

        $host = parse_url($referer, PHP_URL_HOST) ?: $referer;
        $host = strtolower(preg_replace('/^www\./', '', $host));

        return Str::limit($host, 160, '');
    }

    protected function detectDevice(string $agent): string
    {
        $agent = strtolower($agent);

        if (str_contains($agent, 'ipad') || str_contains($agent, 'tablet')) {
            return 'Tablet';
        }

        if (str_contains($agent, 'mobile') || str_contains($agent, 'android') || str_contains($agent, 'iphone')) {
            return 'Mobile';
        }

        return 'Desktop';
    }

    protected function detectBrowser(string $agent): string
    {
        $agent = strtolower($agent);

        return match (true) {
            str_contains($agent, 'edg/') => 'Microsoft Edge',
            str_contains($agent, 'chrome/') => 'Chrome',
            str_contains($agent, 'safari/') && !str_contains($agent, 'chrome/') => 'Safari',
            str_contains($agent, 'firefox/') => 'Firefox',
            default => 'Other',
        };
    }

    protected function isLikelyBot(string $agent): bool
    {
        if (!$agent) {
            return false;
        }

        return Str::contains(strtolower($agent), [
            'bot', 'crawler', 'spider', 'slurp', 'curl', 'wget', 'python-requests', 'headless',
        ]);
    }
}
