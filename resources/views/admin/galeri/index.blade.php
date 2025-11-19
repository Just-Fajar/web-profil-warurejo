@extends('admin.layouts.app')

@section('title', 'Kelola Galeri')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <!-- Revised Header Section (Tailwind style matching your request) -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kelola Galeri</h1>
        <p class="text-gray-500 text-sm">Manajemen foto dan video galeri desa</p>
    </div>
    <a href="{{ route('admin.galeri.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg shadow font-medium flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Galeri
    </a>
</div>

<!-- Flash Messages -->
@if(session('success'))
<div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
    <span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
    <button onclick="this.parentElement.remove()" class="text-green-700">&times;</button>
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
    <span><i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}</span>
    <button onclick="this.parentElement.remove()" class="text-red-700">&times;</button>
</div>
@endif

<!-- Filter Section -->
<div class="bg-white shadow rounded-lg p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
        <div>
            <label class="text-gray-600 text-sm">Cari Galeri: <span id="filterCount" class="text-purple-600 font-semibold"></span></label>
            <input type="text" 
                   id="searchInput" 
                   placeholder="Cari judul..." 
                   class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
        </div>
        
        <div>
            <label class="text-gray-600 text-sm">Filter Kategori:</label>
            <select id="filterKategori" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <option value="">Semua Kategori</option>
                <option value="kegiatan">Kegiatan</option>
                <option value="infrastruktur">Infrastruktur</option>
                <option value="budaya">Budaya</option>
                <option value="umkm">UMKM</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>

        <div>
            <label class="text-gray-600 text-sm">Filter Status:</label>
            <select id="filterStatus" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <option value="">Semua Status</option>
                <option value="1">Aktif</option>
                <option value="0">Non-Aktif</option>
            </select>
        </div>
    </div>
</div>

<!-- Grid Galeri -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="galeriGrid">
    @forelse($galeri as $item)
    <div class="border rounded-lg shadow bg-white overflow-hidden galeri-item hover:shadow-xl transition-shadow" 
         data-judul="{{ strtolower(strip_tags($item->judul)) }}"
         data-kategori="{{ $item->kategori }}" 
         data-status="{{ $item->is_active }}">

        <!-- Thumbnail -->
        <div class="relative h-48 overflow-hidden bg-gray-200">
            <img src="{{ asset('storage/' . $item->gambar) }}" 
                 alt="{{ $item->judul }}"
                 class="w-full h-full object-cover"
                 onerror="this.style.display='none'; this.parentElement.classList.add('bg-gray-300')">
        </div>

        <!-- Body -->
        <div class="p-4">
            <h3 class="font-semibold text-gray-800 text-sm mb-2">{{ Str::limit($item->judul, 50) }}</h3>

            <!-- Badges -->
            <div class="flex justify-between items-center mb-2">
                @php
                    $badgeClass = match($item->kategori) {
                        'kegiatan' => 'bg-green-600',
                        'infrastruktur' => 'bg-blue-500',
                        'budaya' => 'bg-yellow-500',
                        'umkm' => 'bg-purple-600',
                        'lainnya' => 'bg-gray-600',
                        default => 'bg-gray-500'
                    };
                    
                    $kategoriLabel = match($item->kategori) {
                        'kegiatan' => 'Kegiatan',
                        'infrastruktur' => 'Infrastruktur',
                        'budaya' => 'Budaya',
                        'umkm' => 'UMKM',
                        'lainnya' => 'Lainnya',
                        default => ucfirst($item->kategori)
                    };
                @endphp
                <span class="text-white text-xs px-2 py-1 rounded {{ $badgeClass }}">{{ $kategoriLabel }}</span>

                <span class="text-white text-xs px-2 py-1 rounded {{ $item->is_active ? 'bg-green-600' : 'bg-gray-500' }}">
                    {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                </span>
            </div>

            <p class="text-xs text-gray-500 mb-2">
                <i class="fas fa-calendar mr-1"></i>
                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
            </p>

            @if($item->deskripsi)
            <p class="text-xs text-gray-700">{{ Str::limit($item->deskripsi, 60) }}</p>
            @endif
        </div>

        <!-- Footer -->
        <div class="border-t p-3 flex gap-2">
            <a href="{{ route('admin.galeri.edit', $item->id) }}" 
               class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded text-center text-sm">
                <i class="fas fa-edit"></i>
            </a>

            <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" class="flex-1 delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded text-sm">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>

    </div>
    @empty
    <div class="col-span-4 text-center py-10">
        <i class="fas fa-images text-5xl text-gray-400 mb-3"></i>
        <h3 class="text-gray-600 text-lg font-medium">Belum ada galeri</h3>
        <p class="text-gray-500">Tambahkan foto pertama Anda</p>
        <a href="{{ route('admin.galeri.create') }}" class="mt-3 inline-block bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg shadow">
            <i class="fas fa-plus mr-1"></i> Tambah Galeri
        </a>
    </div>
    @endforelse
</div>
@endsection

@push('styles')
<style>
    .galeri-item {
        transition: all 0.3s ease;
    }
    .galeri-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endpush

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    function filterGaleri() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase().trim();
        const kategoriFilter = document.getElementById('filterKategori').value.toLowerCase();
        const statusFilter = document.getElementById('filterStatus').value;
        
        let visibleCount = 0;

        document.querySelectorAll('.galeri-item').forEach(function(item) {
            const itemJudul = item.dataset.judul.toLowerCase();
            const itemKategori = item.dataset.kategori.toLowerCase();
            const itemStatus = item.dataset.status.toString();

            let showItem = true;

            // Filter by search
            if (searchValue && !itemJudul.includes(searchValue)) {
                showItem = false;
            }
            
            // Filter by kategori
            if (kategoriFilter && itemKategori !== kategoriFilter) {
                showItem = false;
            }
            
            // Filter by status
            if (statusFilter && itemStatus !== statusFilter) {
                showItem = false;
            }

            if (showItem) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Update counter
        const totalItems = document.querySelectorAll('.galeri-item').length;
        document.getElementById('filterCount').textContent = `(${visibleCount}/${totalItems})`;
    }

    // Add event listeners
    document.getElementById('searchInput').addEventListener('keyup', filterGaleri);
    document.getElementById('filterKategori').addEventListener('change', filterGaleri);
    document.getElementById('filterStatus').addEventListener('change', filterGaleri);
    
    // Initialize counter
    filterGaleri();

    // Single Delete Confirmation
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const currentForm = this;

            Swal.fire({
                title: 'Hapus Galeri?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    currentForm.submit();
                }
            });
        });
    });

    // Auto-hide alerts
    setTimeout(function() {
        document.querySelectorAll('.bg-green-100, .bg-red-100').forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
});
</script>
@endpush
