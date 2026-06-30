<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorLog;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class VisitorAnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        $range = (int) $request->query('range', 30);
        if (!in_array($range, [7, 30, 90, 365], true)) {
            $range = 30;
        }

        $from = now()->subDays($range - 1)->startOfDay();
        $rangeQuery = VisitorLog::query()->where('created_at', '>=', $from);

        $dailyRows = (clone $rangeQuery)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as views, COUNT(DISTINCT visitor_hash) as visitors')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $dailyTraffic = collect(CarbonPeriod::create($from->copy()->startOfDay(), now()->startOfDay()))
            ->map(function ($date) use ($dailyRows) {
                $key = $date->format('Y-m-d');
                $row = $dailyRows->get($key);

                return [
                    'label' => $date->format('d M'),
                    'date' => $key,
                    'views' => (int) ($row->views ?? 0),
                    'visitors' => (int) ($row->visitors ?? 0),
                ];
            });

        $maxDailyViews = max(1, (int) $dailyTraffic->max('views'));

        $topPages = (clone $rangeQuery)
            ->select('path', DB::raw('COUNT(*) as total'))
            ->groupBy('path')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $trafficSources = (clone $rangeQuery)
            ->select('source', DB::raw('COUNT(*) as total'))
            ->groupBy('source')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $devices = (clone $rangeQuery)
            ->select('device', DB::raw('COUNT(*) as total'))
            ->groupBy('device')
            ->orderByDesc('total')
            ->get();

        $totalViews = VisitorLog::count();
        $totalVisitors = VisitorLog::distinct('visitor_hash')->count('visitor_hash');
        $rangeViews = (clone $rangeQuery)->count();
        $rangeVisitors = (clone $rangeQuery)->distinct('visitor_hash')->count('visitor_hash');
        $todayViews = VisitorLog::whereDate('created_at', today())->count();
        $todayVisitors = VisitorLog::whereDate('created_at', today())->distinct('visitor_hash')->count('visitor_hash');
        $monthViews = VisitorLog::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count();
        $monthVisitors = VisitorLog::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->distinct('visitor_hash')->count('visitor_hash');

        return view('admin.analytics.index', compact(
            'range',
            'dailyTraffic',
            'maxDailyViews',
            'topPages',
            'trafficSources',
            'devices',
            'totalViews',
            'totalVisitors',
            'rangeViews',
            'rangeVisitors',
            'todayViews',
            'todayVisitors',
            'monthViews',
            'monthVisitors'
        ));
    }
}
