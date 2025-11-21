<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        try {
            // Implement settings update logic here
            // TODO: Add actual settings update logic when needed
            
            return redirect()->route('admin.settings.index')
                ->with('success', 'Pengaturan berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Error updating settings', [
                'admin_id' => auth()->guard('admin')->id(),
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan pengaturan: ' . $e->getMessage());
        }
    }
}
