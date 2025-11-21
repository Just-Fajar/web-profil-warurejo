<?php

namespace App\Services;

use App\Models\Visitor;
use App\Models\DailyVisitorStat;
use Carbon\Carbon;

class VisitorStatisticsService
{
    /**
     * Get today's unique visitors
     */
    public function getTodayVisitors(): int
    {
        return Visitor::where('visit_date', Carbon::today()->toDateString())
                      ->distinct('device_fingerprint')
                      ->count();
    }
    
    /**
     * Get weekly unique visitors (last 7 days)
     */
    public function getWeeklyVisitors(): int
    {
        return Visitor::where('visit_date', '>=', Carbon::now()->subDays(7)->toDateString())
                      ->distinct('device_fingerprint')
                      ->count();
    }
    
    /**
     * Get monthly unique visitors (last 30 days)
     */
    public function getMonthlyVisitors(): int
    {
        return Visitor::where('visit_date', '>=', Carbon::now()->subDays(30)->toDateString())
                      ->distinct('device_fingerprint')
                      ->count();
    }
    
    /**
     * Get total unique visitors (all time)
     */
    public function getTotalVisitors(): int
    {
        return Visitor::distinct('device_fingerprint')->count();
    }

    /**
     * Get today's total page views
     */
    public function getTodayPageViews(): int
    {
        return Visitor::where('visit_date', Carbon::today()->toDateString())->count();
    }
    
    /**
     * Get chart data for specified number of days
     * Returns labels, visitors, and pageViews arrays
     */
    public function getChartData(int $days = 30): array
    {
        $startDate = Carbon::now()->subDays($days - 1)->toDateString();
        $endDate = Carbon::today()->toDateString();
        
        $stats = DailyVisitorStat::whereBetween('date', [$startDate, $endDate])
                                 ->orderBy('date', 'asc')
                                 ->get();
        
        // Fill missing dates with zeros
        $filledStats = [];
        $currentDate = Carbon::parse($startDate);
        
        while ($currentDate->lte(Carbon::parse($endDate))) {
            $dateStr = $currentDate->toDateString();
            $stat = $stats->firstWhere('date', $dateStr);
            
            $filledStats[] = [
                'date' => $dateStr,
                'unique_visitors' => $stat ? $stat->unique_visitors : 0,
                'page_views' => $stat ? $stat->page_views : 0,
            ];
            
            $currentDate->addDay();
        }
        
        return [
            'labels' => array_map(fn($s) => Carbon::parse($s['date'])->format('d M'), $filledStats),
            'visitors' => array_column($filledStats, 'unique_visitors'),
            'pageViews' => array_column($filledStats, 'page_views'),
        ];
    }

    /**
     * Get visitor growth percentage compared to yesterday
     */
    public function getVisitorGrowth(): float
    {
        $today = $this->getTodayVisitors();
        $yesterday = Visitor::where('visit_date', Carbon::yesterday()->toDateString())
                            ->distinct('device_fingerprint')
                            ->count();
        
        if ($yesterday == 0) {
            return $today > 0 ? 100.0 : 0.0;
        }
        
        return round((($today - $yesterday) / $yesterday) * 100, 1);
    }

    /**
     * Get most visited pages today
     */
    public function getMostVisitedPages(int $limit = 10): array
    {
        return Visitor::where('visit_date', Carbon::today()->toDateString())
                      ->select('page_url', \DB::raw('count(*) as visit_count'))
                      ->groupBy('page_url')
                      ->orderByDesc('visit_count')
                      ->limit($limit)
                      ->get()
                      ->toArray();
    }

    /**
     * Clean up old visitor data (older than specified days)
     */
    public function cleanupOldData(int $daysToKeep = 90): int
    {
        $cutoffDate = Carbon::now()->subDays($daysToKeep)->toDateString();
        
        return Visitor::where('visit_date', '<', $cutoffDate)->delete();
    }

    /**
     * Aggregate yesterday's data into daily stats
     * This ensures we have backup data even if live counting fails
     */
    public function aggregateYesterdayStats(): void
    {
        $yesterday = Carbon::yesterday()->toDateString();
        
        $uniqueVisitors = Visitor::where('visit_date', $yesterday)
                                 ->distinct('device_fingerprint')
                                 ->count();
        
        $pageViews = Visitor::where('visit_date', $yesterday)->count();
        
        DailyVisitorStat::updateOrCreate(
            ['date' => $yesterday],
            [
                'unique_visitors' => $uniqueVisitors,
                'page_views' => $pageViews,
            ]
        );
    }
}
