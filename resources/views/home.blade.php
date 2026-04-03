@extends('layouts.app')

@section('content')
<!-- ========== HERO BANNER - DENGAN SHADE HITAM & TEXT SHADOW ========== -->
<section class="pt-20 md:pt-16 relative">
    <div class="bg-cover bg-center h-screen relative" style="background-image: url('{{ asset('images/background.png') }}');">
        <!-- OVERLAY SHADE HITAM - AGAR TEKS MENONJOL -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-black/70"></div>
        
        <!-- KONTEN BANNER -->
        <div class="absolute inset-0 flex flex-col justify-center items-start text-left px-10 md:px-24">
            <!-- Badge kecil -->
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-4 py-1.5 mb-6">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                <span class="text-white text-sm font-medium">Platform Pengaduan Resmi</span>
            </div>
            
            <!-- Teks Utama dengan Text Shadow -->
            <h1 class="text-4xl md:text-7xl font-extrabold text-white leading-tight drop-shadow-[0_4px_12px_rgba(0,0,0,0.5)]">
                Selamat Datang di
            </h1>
            <h1 class="text-4xl md:text-7xl font-extrabold leading-tight mt-3 drop-shadow-[0_4px_12px_rgba(0,0,0,0.5)]">
                <span class="text-white">Laporin</span><span class="text-orange-400">Aja</span>
            </h1>
            <p class="mt-6 text-lg md:text-xl text-white/95 drop-shadow-[0_2px_8px_rgba(0,0,0,0.4)] max-w-2xl">
                Sampaikan aspirasi, laporkan masalah, wujudkan perubahan bersama-sama
            </p>
            
            <!-- Tombol Aksi -->
            <div class="mt-10 flex flex-wrap gap-5">
                <a href="{{ route('register') }}" class="group relative px-8 py-3.5 bg-gradient-to-r from-blue-500 to-blue-700 text-white font-bold rounded-full hover:from-blue-600 hover:to-blue-800 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105">
                    <i class="fas fa-pen-alt mr-2"></i>
                    Buat Laporan
                    <span class="absolute inset-0 rounded-full bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                </a>
                <a href="#tentang" class="px-8 py-3.5 border-2 border-white/80 text-white font-bold rounded-full hover:bg-white/20 hover:border-white transition-all duration-300 backdrop-blur-sm">
                    <i class="fas fa-play-circle mr-2"></i>
                    Pelajari Lebih
                </a>
            </div>
            
            <!-- Statistik mini -->
            <div class="grid grid-cols-3 gap-8 mt-16 pt-8 border-t border-white/20">
                <div>
                    <div class="text-2xl md:text-3xl font-bold text-white drop-shadow-md">10K+</div>
                    <div class="text-white/70 text-sm">Laporan Masuk</div>
                </div>
                <div>
                    <div class="text-2xl md:text-3xl font-bold text-white drop-shadow-md">8.5K+</div>
                    <div class="text-white/70 text-sm">Terselesaikan</div>
                </div>
                <div>
                    <div class="text-2xl md:text-3xl font-bold text-white drop-shadow-md">98%</div>
                    <div class="text-white/70 text-sm">Kepuasan</div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#statistik" class="text-white/60 hover:text-white transition">
                <i class="fas fa-chevron-down text-2xl"></i>
            </a>
        </div>
    </div>
</section>

<!-- ========== STATISTIK SECTION ========== -->
<section id="statistik" class="py-16 bg-white fade-in">
    <div class="container mx-auto px-8 md:px-32">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-50 to-white shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-3xl md:text-4xl font-extrabold text-blue-600 mb-2">10K+</div>
                <div class="text-gray-600 font-medium">Laporan Masuk</div>
            </div>
            <div class="p-6 rounded-2xl bg-gradient-to-br from-green-50 to-white shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-3xl md:text-4xl font-extrabold text-green-500 mb-2">8.5K+</div>
                <div class="text-gray-600 font-medium">Terselesaikan</div>
            </div>
            <div class="p-6 rounded-2xl bg-gradient-to-br from-orange-50 to-white shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-3xl md:text-4xl font-extrabold text-orange-500 mb-2">98%</div>
                <div class="text-gray-600 font-medium">Tingkat Kepuasan</div>
            </div>
            <div class="p-6 rounded-2xl bg-gradient-to-br from-purple-50 to-white shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-3xl md:text-4xl font-extrabold text-purple-500 mb-2">500+</div>
                <div class="text-gray-600 font-medium">Instansi Terlibat</div>
            </div>
        </div>
    </div>
</section>

<!-- ========== TENTANG KAMI SECTION ========== -->
<section id="tentang" class="py-20 px-8 md:px-32 fade-in bg-gradient-to-br from-blue-50 to-white">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <span class="text-blue-500 font-semibold text-sm uppercase tracking-wide">Tentang Kami</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">
                Mengapa Memilih <span class="text-blue-600">LaporinAja</span>?
            </h2>
            <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-orange-500 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="flex flex-col md:flex-row gap-10 items-stretch">
            <div class="flex-shrink-0 md:w-1/3">
                <div class="relative rounded-2xl overflow-hidden shadow-xl h-full">
                    <img 
                        src="{{ asset('images/background.png') }}" 
                        alt="Ilustrasi Laporan" 
                        class="w-full h-full object-cover"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <p class="text-white font-bold text-lg">LaporinAja</p>
                        <p class="text-white/80 text-sm">#SuaramuBerharga</p>
                    </div>
                </div>
            </div>

            <div class="flex-1 bg-white rounded-2xl shadow-xl p-8 md:p-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-quote-left text-blue-500 text-xl"></i>
                    </div>
                    <p class="text-blue-600 font-semibold">Sambutan</p>
                </div>
                <p class="text-gray-700 leading-relaxed mb-4 text-lg">
                    <span class="font-bold text-gray-900">LaporinAja</span> hadir sebagai solusi inovatif untuk menjembatani aspirasi masyarakat dengan pemerintah.
                </p>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Kami percaya bahwa setiap warga berhak mendapatkan pelayanan publik yang terbaik, transparan, dan akuntabel. Melalui platform ini, Anda dapat menyampaikan keluhan, melaporkan masalah, serta memberikan masukan secara mudah dan cepat.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Setiap laporan yang masuk akan kami teruskan ke instansi terkait dan dapat dipantau secara real-time. Bersama kita wujudkan perubahan!
                </p>
                <div class="mt-6 flex gap-2">
                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                    <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                    <div class="w-2 h-2 rounded-full bg-blue-300"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== LAYANAN UNGGULAN ========== -->
<section id="layanan" class="py-20 bg-white fade-in">
    <div class="container mx-auto px-8 md:px-32">
        <div class="text-center mb-14">
            <span class="text-orange-500 font-semibold text-sm uppercase tracking-wide">Layanan Kami</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">
                Layanan <span class="text-blue-600">Unggulan</span>
            </h2>
            <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-orange-500 mx-auto mt-4 rounded-full"></div>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto">Fitur lengkap untuk memudahkan Anda menyampaikan aspirasi</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-b-4 border-blue-500">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-blue-500 transition-colors duration-300">
                    <i class="fas fa-edit text-blue-600 text-2xl group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Laporan Instan</h3>
                <p class="text-gray-500 leading-relaxed">Buat laporan dalam 2 menit dengan form yang sederhana dan mudah dipahami</p>
            </div>

            <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-b-4 border-green-500">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-green-500 transition-colors duration-300">
                    <i class="fas fa-chart-line text-green-600 text-2xl group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Tracking Real-time</h3>
                <p class="text-gray-500 leading-relaxed">Pantau status laporan Anda secara langsung dengan notifikasi update</p>
            </div>

            <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-b-4 border-orange-500">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-orange-500 transition-colors duration-300">
                    <i class="fas fa-shield-alt text-orange-600 text-2xl group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Privasi Terjaga</h3>
                <p class="text-gray-500 leading-relaxed">Data pribadi Anda terlindungi dengan enkripsi tingkat tinggi</p>
            </div>
        </div>
    </div>
</section>

<!-- ========== CARA MENGAJUAN PENGADUAN ========== -->
<section class="py-20 px-8 md:px-32 bg-gradient-to-br from-gray-50 to-white fade-in">
    <div class="container mx-auto">
        <div class="text-center mb-14">
            <span class="text-blue-500 font-semibold text-sm uppercase tracking-wide">Panduan</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">
                Cara <span class="text-orange-500">Mengajukan Pengaduan</span>
            </h2>
            <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-orange-500 mx-auto mt-4 rounded-full"></div>
            <p class="text-gray-500 mt-4">Mudah, cepat, dan aman</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center group">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-500 transition-all duration-300 shadow-md group-hover:shadow-xl">
                    <i class="fas fa-user-plus text-blue-600 text-2xl group-hover:text-white"></i>
                </div>
                <div class="text-2xl font-bold text-blue-500 mb-2">01</div>
                <h3 class="font-bold text-gray-800 mb-2">Daftar Akun</h3>
                <p class="text-gray-500 text-sm">Registrasi dengan email & nomor telepon</p>
            </div>
            <div class="text-center group">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-500 transition-all duration-300 shadow-md group-hover:shadow-xl">
                    <i class="fas fa-pen-alt text-green-600 text-2xl group-hover:text-white"></i>
                </div>
                <div class="text-2xl font-bold text-green-500 mb-2">02</div>
                <h3 class="font-bold text-gray-800 mb-2">Buat Laporan</h3>
                <p class="text-gray-500 text-sm">Isi form & upload bukti pendukung</p>
            </div>
            <div class="text-center group">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-500 transition-all duration-300 shadow-md group-hover:shadow-xl">
                    <i class="fas fa-clock text-orange-600 text-2xl group-hover:text-white"></i>
                </div>
                <div class="text-2xl font-bold text-orange-500 mb-2">03</div>
                <h3 class="font-bold text-gray-800 mb-2">Verifikasi</h3>
                <p class="text-gray-500 text-sm">Tim verifikasi akan memproses laporan</p>
            </div>
            <div class="text-center group">
                <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-500 transition-all duration-300 shadow-md group-hover:shadow-xl">
                    <i class="fas fa-check-circle text-purple-600 text-2xl group-hover:text-white"></i>
                </div>
                <div class="text-2xl font-bold text-purple-500 mb-2">04</div>
                <h3 class="font-bold text-gray-800 mb-2">Tindak Lanjut</h3>
                <p class="text-gray-500 text-sm">Diteruskan ke instansi terkait</p>
            </div>
        </div>
    </div>
</section>

<!-- ========== CTA SECTION ========== -->
<section class="py-20 px-8 md:px-32 fade-in">
    <div class="max-w-5xl mx-auto bg-gradient-to-r from-blue-600 to-blue-800 rounded-3xl p-12 text-center shadow-2xl">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 drop-shadow-lg">
            Siap Menyampaikan Aspirasimu?
        </h2>
        <p class="text-blue-100 mb-8 text-lg max-w-2xl mx-auto">
            Bergabunglah bersama ribuan warga yang sudah menggunakan LaporinAja
        </p>
        <a href="{{ route('register') }}" class="inline-flex items-center gap-3 bg-white text-blue-700 px-8 py-4 rounded-full font-bold text-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
            <i class="fas fa-pen-alt"></i>
            Buat Laporan Sekarang
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</section>

<!-- ========== KONTAK SECTION ========== -->
<section id="kontak" class="py-20 bg-white fade-in">
    <div class="container mx-auto px-8 md:px-32">
        <div class="text-center mb-14">
            <span class="text-blue-500 font-semibold text-sm uppercase tracking-wide">Hubungi Kami</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">
                Ada <span class="text-orange-500">Pertanyaan</span>?
            </h2>
            <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-orange-500 mx-auto mt-4 rounded-full"></div>
            <p class="text-gray-500 mt-4">Tim kami siap membantu Anda</p>
        </div>

        <div class="grid md:grid-cols-2 gap-10">
            <div class="space-y-6">
                <div class="flex items-start gap-5 p-6 bg-gradient-to-r from-blue-50 to-white rounded-2xl shadow-md hover:shadow-lg transition-all">
                    <div class="w-14 h-14 bg-blue-500 rounded-2xl flex items-center justify-center shadow-md">
                        <i class="fas fa-map-marker-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg mb-1">Alamat Kantor</h3>
                        <p class="text-gray-600">Jakarta, Indonesia</p>
                    </div>
                </div>
                <div class="flex items-start gap-5 p-6 bg-gradient-to-r from-green-50 to-white rounded-2xl shadow-md hover:shadow-lg transition-all">
                    <div class="w-14 h-14 bg-green-500 rounded-2xl flex items-center justify-center shadow-md">
                        <i class="fas fa-phone-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg mb-1">Telepon</h3>
                        <p class="text-gray-600">(021) 1234-5678</p>
                    </div>
                </div>
                <div class="flex items-start gap-5 p-6 bg-gradient-to-r from-orange-50 to-white rounded-2xl shadow-md hover:shadow-lg transition-all">
                    <div class="w-14 h-14 bg-orange-500 rounded-2xl flex items-center justify-center shadow-md">
                        <i class="fas fa-envelope text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg mb-1">Email</h3>
                        <p class="text-gray-600">info@laporinaja.go.id</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <form>
                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" placeholder="Masukkan nama Anda">
                    </div>
                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold mb-2">Email</label>
                        <input type="email" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" placeholder="email@anda.com">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Pesan</label>
                        <textarea rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" placeholder="Tulis pesan Anda..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection