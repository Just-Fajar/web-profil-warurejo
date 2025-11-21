<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.profile.show', compact('admin'));
    }

    public function edit()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.profile.edit', compact('admin'));
    }

    public function update(Request $request)
    {
        try {
            /** @var \App\Models\Admin $admin */
            $admin = auth()->guard('admin')->user();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            ]);

            $admin->update($validated);

            return redirect()->route('admin.profile.show')
                ->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating admin profile', [
                'admin_id' => auth()->guard('admin')->id(),
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            /** @var \App\Models\Admin $admin */
            $admin = auth()->guard('admin')->user();

            // Cek apakah mode lupa password
            $lupaPassword = $request->has('lupa_password');

            if ($lupaPassword) {
                // Mode LUPA PASSWORD: Verifikasi email, tidak perlu password lama
                $validated = $request->validate([
                    'email_verifikasi' => 'required|email',
                    'password' => ['required', 'confirmed', Password::min(8)],
                ], [
                    'email_verifikasi.required' => 'Email wajib diisi untuk verifikasi',
                    'email_verifikasi.email' => 'Format email tidak valid',
                ]);

                // Validasi email harus sama dengan email admin yang login
                if (strtolower($request->email_verifikasi) !== strtolower($admin->email)) {
                    return back()->withErrors(['email_verifikasi' => 'Email tidak sesuai dengan akun Anda!']);
                }

            } else {
                // Mode NORMAL: Perlu password lama
                $validated = $request->validate([
                    'current_password' => 'required',
                    'password' => ['required', 'confirmed', Password::min(8)],
                ]);

                // Check current password
                if (!Hash::check($request->current_password, $admin->password)) {
                    return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
                }
            }

            // Update password
            $admin->update([
                'password' => Hash::make($validated['password'])
            ]);

            $message = $lupaPassword 
                ? 'Password berhasil direset!' 
                : 'Password berhasil diubah!';

            return redirect()->route('admin.profile.show')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            Log::error('Error updating admin password', [
                'admin_id' => auth()->guard('admin')->id(),
                'exception' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui password: ' . $e->getMessage());
        }
    }
}
