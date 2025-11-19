<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;
use App\Models\DailyVisitorStat;
use Illuminate\Support\Facades\DB;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     * Track visitor secara OTOMATIS tanpa user action apapun
     * Tidak perlu login, tidak perlu registrasi, 100% background process
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking untuk route admin dan asset files
        if ($request->is('admin/*') || $request->is('storage/*') || $request->is('build/*')) {
            return $next($request);
        }

        try {
            // Generate device fingerprint (anonymous, tidak ada data personal)
            $fingerprint = $this->generateFingerprint($request);
            
            // Check jika sudah visit hari ini
            $today = now()->toDateString();
            $visitor = Visitor::where('device_fingerprint', $fingerprint)
                              ->where('visit_date', $today)
                              ->first();
            
            if (!$visitor) {
                // Visitor baru atau belum visit hari ini
                // Langsung create tanpa user interaction
                Visitor::create([
                    'ip_address' => $this->anonymizeIp($request->ip()), // IP di-anonymize
                    'user_agent' => $request->userAgent() ?? 'Unknown',
                    'device_fingerprint' => $fingerprint,
                    'visit_date' => $today,
                    'last_visit_at' => now(),
                    'page_url' => $request->fullUrl(),
                    'referer' => $request->header('referer'),
                ]);
                
                // Update daily stats
                $this->updateDailyStats($today);
            } else {
                // Update last visit (tapi tidak menambah counter hari ini - ANTI SPAM)
                $visitor->update([
                    'last_visit_at' => now(),
                    'page_url' => $request->fullUrl(),
                    'visit_count' => DB::raw('visit_count + 1'),
                ]);
            }
        } catch (\Exception $e) {
            // Silent fail - tidak mengganggu user experience
            \Log::error('Visitor tracking error: ' . $e->getMessage());
        }
        
        // Lanjutkan request seperti biasa (user tidak tahu ada tracking)
        return $next($request);
    }
    
    /**
     * Generate anonymous fingerprint
     * TIDAK menyimpan data personal, hanya hash
     */
    private function generateFingerprint(Request $request): string
    {
        // Kombinasi IP + User-Agent + Accept-Language
        $data = ($request->ip() ?? 'unknown')
              . '|' . ($request->userAgent() ?? 'unknown')
              . '|' . ($request->header('Accept-Language') ?? 'unknown');
        
        // Hash SHA-256 (tidak bisa di-reverse engineer)
        return hash('sha256', $data);
    }
    
    /**
     * Anonymize IP untuk privacy
     * Contoh: 192.168.1.100 → 192.168.1.0
     */
    private function anonymizeIp(?string $ip): string
    {
        if (!$ip) {
            return '0.0.0.0';
        }

        $parts = explode('.', $ip);
        if (count($parts) === 4) {
            $parts[3] = '0'; // Hide last octet
            return implode('.', $parts);
        }
        return $ip;
    }
    
    /**
     * Update daily statistics
     */
    private function updateDailyStats(string $date): void
    {
        try {
            DailyVisitorStat::updateOrCreate(
                ['date' => $date],
                [
                    'unique_visitors' => DB::raw('unique_visitors + 1'),
                    'page_views' => DB::raw('page_views + 1'),
                ]
            );
        } catch (\Exception $e) {
            \Log::error('Daily stats update error: ' . $e->getMessage());
        }
    }
}
