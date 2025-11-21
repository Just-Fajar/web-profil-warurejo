@extends('public.layouts.app')

@section('title', 'Hubungi Kami')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Hubungi Kami</h1>
            <p class="text-lg text-gray-600">
                Silakan hubungi kami melalui kontak di bawah ini
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Contact Info -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Kontak</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-2xl text-green-600 mr-4 mt-1"></i>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Alamat</h3>
                            <p class="text-gray-600">{{ $profil->alamat }}</p>
                            <p class="text-gray-600">{{ $profil->kecamatan }}, {{ $profil->kabupaten }}</p>
                            <p class="text-gray-600">{{ $profil->provinsi }} {{ $profil->kode_pos }}</p>
                        </div>
                    </div>

                    @if($profil->telepon)
                    <div class="flex items-start">
                        <i class="fas fa-phone text-2xl text-green-600 mr-4 mt-1"></i>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Telepon</h3>
                            <p class="text-gray-600">{{ $profil->telepon }}</p>
                        </div>
                    </div>
                    @endif

                    @if($profil->email)
                    <div class="flex items-start">
                        <i class="fas fa-envelope text-2xl text-green-600 mr-4 mt-1"></i>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Email</h3>
                            <p class="text-gray-600">{{ $profil->email }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="flex items-start">
                        <i class="fas fa-clock text-2xl text-green-600 mr-4 mt-1"></i>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Jam Layanan</h3>
                            <p class="text-gray-600">Senin - Jumat: 08:00 - 16:00</p>
                            <p class="text-gray-600">Sabtu: 08:00 - 12:00</p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                @if($profil->facebook || $profil->instagram || $profil->youtube || $profil->twitter)
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="font-semibold text-gray-800 mb-4">Media Sosial</h3>
                    <div class="flex space-x-4">
                        @if($profil->facebook)
                        <a href="{{ $profil->facebook }}" target="_blank" class="w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        
                        @if($profil->instagram)
                        <a href="https://instagram.com/{{ $profil->instagram }}" target="_blank" class="w-10 h-10 bg-pink-600 hover:bg-pink-700 text-white rounded-full flex items-center justify-center transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @endif
                        
                        @if($profil->youtube)
                        <a href="{{ $profil->youtube }}" target="_blank" class="w-10 h-10 bg-red-600 hover:bg-red-700 text-white rounded-full flex items-center justify-center transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                        @endif
                        
                        @if($profil->twitter)
                        <a href="https://twitter.com/{{ $profil->twitter }}" target="_blank" class="w-10 h-10 bg-sky-500 hover:bg-sky-600 text-white rounded-full flex items-center justify-center transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- WhatsApp Contact -->
            <div class="bg-gradient-to-br from-green-600 to-green-700 text-white rounded-lg shadow-lg p-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6">
                        <i class="fab fa-whatsapp text-5xl"></i>
                    </div>
                    
                    <h2 class="text-2xl font-bold mb-4">Hubungi Via WhatsApp</h2>
                    <p class="text-white/90 mb-8">
                        Kirim pesan langsung ke WhatsApp kami untuk respon lebih cepat
                    </p>

                    @if($profil->telepon)
                    @php
                        // Format nomor untuk WhatsApp (hapus spasi, strip, dan tambah 62)
                        $wa_number = preg_replace('/[^0-9]/', '', $profil->telepon);
                        
                        // Jika diawali dengan 0, ganti dengan 62
                        if (substr($wa_number, 0, 1) === '0') {
                            $wa_number = '62' . substr($wa_number, 1);
                        }
                        
                        // Jika belum ada kode negara, tambahkan 62
                        if (substr($wa_number, 0, 2) !== '62') {
                            $wa_number = '62' . $wa_number;
                        }
                        
                        $wa_link = "https://wa.me/{$wa_number}?text=Halo%20Desa%20Warurejo%2C%20saya%20ingin%20bertanya%20tentang%3A%20";
                    @endphp
                    
                    <a href="{{ $wa_link }}" 
                       target="_blank"
                       class="inline-flex items-center justify-center bg-white text-green-600 font-semibold px-8 py-4 rounded-lg hover:bg-green-50 transition-all transform hover:scale-105 shadow-lg">
                        <i class="fab fa-whatsapp text-2xl mr-3"></i>
                        <span class="text-lg">Chat WhatsApp</span>
                    </a>

                    <div class="mt-6 text-white/80 text-sm">
                        <p>Nomor WhatsApp:</p>
                        <p class="text-xl font-semibold text-white mt-1">{{ $profil->telepon }}</p>
                    </div>
                    @else
                    <p class="text-white/80">Nomor WhatsApp belum tersedia</p>
                    @endif
                </div>

                <div class="mt-8 pt-8 border-t border-white/20">
                    <div class="space-y-3 text-sm text-white/90">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Respon cepat dari petugas</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Layanan tersedia saat jam kerja</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Gratis dan mudah digunakan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map (Optional) -->
        @if($profil->latitude && $profil->longitude)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Lokasi Kami</h2>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden" style="height: 400px;">
                <iframe 
                    src="https://www.google.com/maps?q={{ $profil->latitude }},{{ $profil->longitude }}&hl=es;z=14&output=embed"
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
