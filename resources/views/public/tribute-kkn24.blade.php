{{--
    TRIBUTE PAGE - KKN 24 UNIPMA
    
    Halaman penghargaan untuk tim developer KKN Kelompok 24
    Hanya menampilkan foto tim
    
    Route: /tribute-kkn24
    Controller: Closure route di web.php
--}}
@extends('public.layouts.app')

@section('title', 'Tribute for Developers - KKN 24')

@section('content')

{{-- Hero Section --}}
<section class="bg-linear-to-r from-primary-700 to-primary-900 text-white py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-3">Tribute</h1>
        <p class="text-lg sm:text-xl text-primary-100">Kelompok 24 KKN-T Berdampak UNIPMA 2025</p>
    </div>
</section>

{{-- Photo Gallery Section --}}
<section class="py-12 md:py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">

        {{-- Photo Grid - Anda bisa menambahkan foto tim di sini --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            
            {{-- Placeholder untuk foto tim - Ganti dengan foto asli --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="aspect-3/4 bg-gray-200 flex items-center justify-center">
                    <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-bold text-gray-800 mb-1">Nama Anggota 1</h3>
                    <p class="text-sm text-gray-600">Posisi/Role</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="aspect-3/4 bg-gray-200 flex items-center justify-center">
                    <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-bold text-gray-800 mb-1">Nama Anggota 2</h3>
                    <p class="text-sm text-gray-600">Posisi/Role</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="aspect-3/4 bg-gray-200 flex items-center justify-center">
                    <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-bold text-gray-800 mb-1">Nama Anggota 3</h3>
                    <p class="text-sm text-gray-600">Posisi/Role</p>
                </div>
            </div>

        </div>

        {{-- Back to Home Button --}}
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition shadow-md">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

    </div>
</section>

<style>
/* Scroll-triggered animations */
.scroll-reveal {
    opacity: 0;
    transform: translateY(50px);
    transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}

.scroll-reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}
</style>

<script>
// Scroll-triggered animation observer
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        root: null,
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
            }
        });
    }, observerOptions);

    // Observe all elements with scroll-reveal classes
    document.querySelectorAll('.scroll-reveal').forEach(el => {
        observer.observe(el);
    });
});
</script>

@endsection
