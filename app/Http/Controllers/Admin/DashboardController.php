<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Feature;
use App\Models\GoogleMapSection;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\SocialMediaLink;
use App\Models\SocialWidget;
use App\Models\VisitorLog;
use App\Models\User;
use App\Models\WhatsappCustomerService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $setting = SiteSetting::firstOrCreate([], ['site_name' => 'Hok Cup']);
        $googleMap = GoogleMapSection::first();

        return view('admin.dashboard', [
            'setting' => $setting,
            'productCount' => Product::count(),
            'activeProductCount' => Product::where('is_active', true)->count(),
            'userCount' => User::count(),
            'developerCount' => User::where('role', 'developer')->count(),
            'categoryCount' => Category::count(),
            'featureCount' => Feature::count(),
            'socialWidgetCount' => SocialWidget::count(),
            'socialMediaCount' => SocialMediaLink::where('is_active', true)->count(),
            'whatsappCsCount' => WhatsappCustomerService::count(),
            'activeWhatsappCsCount' => WhatsappCustomerService::where('is_active', true)->count(),
            'whatsappClickCount' => WhatsappCustomerService::sum('total_clicks'),
            'googleMapIsActive' => (bool) optional($googleMap)->is_active,
            'totalVisitors' => VisitorLog::distinct('visitor_hash')->count('visitor_hash'),
            'totalViews' => VisitorLog::count(),
            'todayVisitors' => VisitorLog::whereDate('created_at', today())->distinct('visitor_hash')->count('visitor_hash'),
            'todayViews' => VisitorLog::whereDate('created_at', today())->count(),
            'trackingItems' => [
                'Google Analytics' => filled($setting->google_analytics_id),
                'Google Tag Manager' => filled($setting->google_tag_manager_id),
                'Meta Pixel' => filled($setting->meta_pixel_id),
                'Google Ads' => filled($setting->google_ads_id),
                'Custom Script' => filled($setting->head_scripts) || filled($setting->body_start_scripts) || filled($setting->body_end_scripts),
            ],
            'seoItems' => [
                'Meta Title' => filled($setting->meta_title),
                'Meta Description' => filled($setting->meta_description),
                'OG Image' => filled($setting->og_image),
                'Robots' => filled($setting->seo_robots),
            ],
        ]);
    }
}
