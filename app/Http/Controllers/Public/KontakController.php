<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ProfilDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class KontakController extends Controller
{
    public function index()
    {
        $profil = ProfilDesa::getInstance();
        
        return view('public.kontak.index', compact('profil'));
    }

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string|max:1000',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'subjek.required' => 'Subjek wajib diisi',
            'pesan.required' => 'Pesan wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $profil = ProfilDesa::getInstance();
            
            // Send email (if configured)
            if ($profil->email) {
                Mail::raw($request->pesan, function ($message) use ($request, $profil) {
                    $message->from($request->email, $request->nama)
                        ->to($profil->email)
                        ->subject($request->subjek);
                });
            }

            return redirect()
                ->back()
                ->with('success', 'Pesan Anda berhasil dikirim. Terima kasih!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.');
        }
    }
}
