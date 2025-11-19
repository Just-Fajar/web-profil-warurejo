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
                'username' => 'required|string|max:255|unique:admins,username,' . $admin->id,
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

            $validated = $request->validate([
                'current_password' => 'required',
                'password' => ['required', 'confirmed', Password::min(8)],
            ]);

            // Check current password
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
            }

            $admin->update([
                'password' => Hash::make($validated['password'])
            ]);

            return redirect()->route('admin.profile.show')
                ->with('success', 'Password berhasil diubah!');
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
