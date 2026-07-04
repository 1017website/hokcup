<?php

use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\AnalyticsAdsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CareerPositionController;
use App\Http\Controllers\Admin\CtaSectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\FooterLinkController;
use App\Http\Controllers\Admin\GoogleMapSectionController;
use App\Http\Controllers\Admin\HeroSectionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SeoSettingController;
use App\Http\Controllers\Admin\SocialMediaLinkController;
use App\Http\Controllers\Admin\SocialWidgetController;
use App\Http\Controllers\Admin\VisitorAnalyticsController;
use App\Http\Controllers\Admin\MaintenanceCommandController;
use App\Http\Controllers\Admin\PartnershipInquiryController as AdminPartnershipInquiryController;
use App\Http\Controllers\Admin\NewsArticleController;
use App\Http\Controllers\Admin\ProfilePasswordController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WhatsappCustomerServiceController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Frontend\ContentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PartnershipInquiryController;
use App\Http\Controllers\Frontend\WhatsappRedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/wa', [WhatsappRedirectController::class, 'redirect'])->name('whatsapp.redirect');
Route::get('/news', [ContentController::class, 'newsIndex'])->name('news.index');
Route::get('/news/{newsArticle:slug}', [ContentController::class, 'news'])->name('news.show');
Route::get('/karir', [ContentController::class, 'careersIndex'])->name('careers.index');
Route::get('/karir/{careerPosition:slug}', [ContentController::class, 'career'])->name('careers.show');
Route::post('/jadi-mitra', [PartnershipInquiryController::class, 'store'])->name('partnership.store');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('login.post');
});

Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/site-settings', [SiteSettingController::class, 'edit'])->name('site-settings.edit');
    Route::put('/site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');
    Route::get('/whatsapp-cs', [WhatsappCustomerServiceController::class, 'index'])->name('whatsapp-cs.index');
    Route::resource('partnership-inquiries', AdminPartnershipInquiryController::class)->parameters(['partnership-inquiries' => 'partnershipInquiry'])->only(['index', 'show', 'update', 'destroy']);
    Route::post('/whatsapp-cs', [WhatsappCustomerServiceController::class, 'store'])->name('whatsapp-cs.store');
    Route::put('/whatsapp-cs/{whatsappCs}', [WhatsappCustomerServiceController::class, 'update'])->name('whatsapp-cs.update');
    Route::delete('/whatsapp-cs/{whatsappCs}', [WhatsappCustomerServiceController::class, 'destroy'])->name('whatsapp-cs.destroy');
    Route::post('/whatsapp-cs/reset-stats', [WhatsappCustomerServiceController::class, 'resetStats'])->name('whatsapp-cs.reset-stats');
    Route::get('/seo', [SeoSettingController::class, 'edit'])->name('seo.edit');
    Route::put('/seo', [SeoSettingController::class, 'update'])->name('seo.update');
    Route::get('/analytics', [VisitorAnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics-ads', [AnalyticsAdsController::class, 'edit'])->name('analytics-ads.edit');
    Route::put('/analytics-ads', [AnalyticsAdsController::class, 'update'])->name('analytics-ads.update');
    Route::get('/commands', [MaintenanceCommandController::class, 'index'])->name('commands.index');
    Route::post('/commands/run', [MaintenanceCommandController::class, 'run'])->name('commands.run');
    Route::get('/profile/password', [ProfilePasswordController::class, 'edit'])->name('profile.password.edit');
    Route::put('/profile/password', [ProfilePasswordController::class, 'update'])->name('profile.password.update');
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('/hero', [HeroSectionController::class, 'edit'])->name('hero.edit');
    Route::put('/hero', [HeroSectionController::class, 'update'])->name('hero.update');
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('features', FeatureController::class)->except(['show']);
    Route::get('/about', [AboutSectionController::class, 'edit'])->name('about.edit');
    Route::put('/about', [AboutSectionController::class, 'update'])->name('about.update');
    Route::resource('social-widgets', SocialWidgetController::class)->except(['show']);
    Route::resource('social-media-links', SocialMediaLinkController::class)->except(['show']);
    Route::get('/google-map', [GoogleMapSectionController::class, 'edit'])->name('google-map.edit');
    Route::put('/google-map', [GoogleMapSectionController::class, 'update'])->name('google-map.update');
    Route::resource('news', NewsArticleController::class)->parameters(['news' => 'newsArticle'])->except(['show']);
    Route::resource('careers', CareerPositionController::class)->parameters(['careers' => 'careerPosition'])->except(['show']);
    Route::get('/cta', [CtaSectionController::class, 'edit'])->name('cta.edit');
    Route::put('/cta', [CtaSectionController::class, 'update'])->name('cta.update');
    Route::resource('footer-links', FooterLinkController::class)->except(['show']);
});
