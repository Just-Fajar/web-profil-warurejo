<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <!-- Footer Content -->
            <div class="footer-section">
                <h4 class="footer-title">Desa Warurejo</h4>
                <p class="footer-text">
                    Website resmi Desa Warurejo, Kecamatan Balerejo, Kabupaten Madiun.
                </p>
            </div>
            
            <div class="footer-section">
                <h4 class="footer-title">Kontak</h4>
                <ul class="footer-list">
                    <li>Email: desa@warurejo.go.id</li>
                    <li>Telp: (0351) 123456</li>
                    <li>Alamat: Jl. Raya Warurejo No. 1</li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4 class="footer-title">Link Cepat</h4>
                <ul class="footer-list">
                    <li><a href="{{ route('beranda') }}">Beranda</a></li>
                    <li><a href="{{ route('profil') }}">Profil</a></li>
                    <li><a href="{{ route('publikasi.index') }}">Publikasi</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Desa Warurejo. Kelompok 24.</p>
        </div>
    </div>
</footer>
