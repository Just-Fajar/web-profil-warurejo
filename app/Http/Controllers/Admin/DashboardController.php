<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\PotensiDesa;
use App\Models\Galeri;
use App\Services\VisitorStatisticsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $visitorService;

    public function __construct(VisitorStatisticsService $visitorService)
    {
        $this->visitorService = $visitorService;
    }

    public function index()
    {
        // Statistik Cards
        $totalBerita = Berita::count();
        $totalPotensi = PotensiDesa::count();
        $totalGaleri = Galeri::count();
        
        // Visitor Statistics (Real Data)
        $pengunjungHariIni = $this->visitorService->getTodayVisitors();
        $pengunjungMingguIni = $this->visitorService->getWeeklyVisitors();
        $pengunjungBulanIni = $this->visitorService->getMonthlyVisitors();
        $totalPengunjung = $this->visitorService->getTotalVisitors();
        $pertumbuhanHariIni = $this->visitorService->getVisitorGrowth();
        $pageViewsHariIni = $this->visitorService->getTodayPageViews();
        
        // Chart Data untuk Visitor Statistics (30 hari)
        $visitorChartData = $this->visitorService->getChartData(30);
        
        // Recent Activities
        $recentBerita = Berita::with('admin')
            ->latest()
            ->take(5)
            ->get();
        
        $recentPotensi = PotensiDesa::latest()
            ->take(5)
            ->get();
        
        $recentGaleri = Galeri::latest()
            ->take(5)
            ->get();
        
        // Monthly Stats untuk Chart (content)
        $monthlyStats = $this->getMonthlyStats();
        
        // Quick Stats
        $beritaPublished = Berita::where('status', 'published')->count();
        $beritaDraft = Berita::where('status', 'draft')->count();
        
        return view('admin.dashboard.index', compact(
            'totalBerita',
            'totalPotensi',
            'totalGaleri',
            'pengunjungHariIni',
            'pengunjungMingguIni',
            'pengunjungBulanIni',
            'totalPengunjung',
            'pertumbuhanHariIni',
            'pageViewsHariIni',
            'visitorChartData',
            'recentBerita',
            'recentPotensi',
            'recentGaleri',
            'monthlyStats',
            'beritaPublished',
            'beritaDraft'
        ));
    }
    
    /**
     * Get monthly statistics untuk chart
     */
    private function getMonthlyStats()
    {
        $months = [];
        $beritaData = [];
        $potensiData = [];
        $galeriData = [];
        
        // Data 6 bulan terakhir
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthYear = $date->format('M Y');
            $months[] = $monthYear;
            
            // Hitung data per bulan
            $beritaData[] = Berita::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $potensiData[] = PotensiDesa::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $galeriData[] = Galeri::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }
        
        return [
            'months' => $months,
            'berita' => $beritaData,
            'potensi' => $potensiData,
            'galeri' => $galeriData,
        ];
    }
}
