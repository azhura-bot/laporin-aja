@extends('layouts.dashboard.index')

@section('dashboard-content')
<div class="fade-in">
    <!-- Welcome Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 rounded-2xl shadow-xl p-8 mb-8 text-white">
        <div class="absolute right-0 top-0 opacity-10">
            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
            </svg>
        </div>
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-3">
                <div class="bg-white/20 backdrop-blur rounded-full p-2">
                    <i class="fas fa-hand-peace text-2xl"></i>
                </div>
                <span class="text-blue-100">Selamat datang kembali!</span>
            </div>
            <h1 class="text-3xl font-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-blue-100 text-lg">Platform Pengaduan Masyarakat - LaporinAja</p>
            <div class="mt-4 flex flex-wrap gap-3">
                <div class="bg-white/20 backdrop-blur rounded-full px-4 py-1.5 text-sm">
                    <i class="fas fa-chart-line mr-2"></i> Pantau laporan Anda
                </div>
                <div class="bg-white/20 backdrop-blur rounded-full px-4 py-1.5 text-sm">
                    <i class="fas fa-clock mr-2"></i> Real-time tracking
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <a href="{{ route('laporan.create') }}" 
           class="group relative overflow-hidden bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative p-6 flex items-center gap-5">
                <div class="bg-blue-100 group-hover:bg-white/20 rounded-2xl p-4 transition-all duration-300">
                    <i class="fas fa-plus-circle text-blue-600 text-3xl group-hover:text-white transition-all duration-300"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-white transition-colors duration-300">Buat Laporan Baru</h3>
                    <p class="text-gray-500 group-hover:text-blue-100 text-sm transition-colors duration-300">Laporkan masalah di lingkungan Anda</p>
                </div>
                <i class="fas fa-arrow-right text-gray-400 group-hover:text-white group-hover:translate-x-2 transition-all duration-300"></i>
            </div>
        </a>
        
        <a href="{{ route('laporan.index') }}" 
           class="group relative overflow-hidden bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-green-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative p-6 flex items-center gap-5">
                <div class="bg-green-100 group-hover:bg-white/20 rounded-2xl p-4 transition-all duration-300">
                    <i class="fas fa-eye text-green-600 text-3xl group-hover:text-white transition-all duration-300"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-white transition-colors duration-300">Pantau Aduan</h3>
                    <p class="text-gray-500 group-hover:text-green-100 text-sm transition-colors duration-300">Lihat status laporan Anda</p>
                </div>
                <i class="fas fa-arrow-right text-gray-400 group-hover:text-white group-hover:translate-x-2 transition-all duration-300"></i>
            </div>
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-blue-100 rounded-xl p-3">
                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-blue-600">{{ $totalLaporan }}</span>
            </div>
            <p class="text-gray-600 font-medium">Total Laporan</p>
            <p class="text-gray-400 text-sm mt-1">Semua laporan Anda</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-yellow-100 rounded-xl p-3">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-yellow-600">{{ $laporanPending }}</span>
            </div>
            <p class="text-gray-600 font-medium">Menunggu</p>
            <p class="text-gray-400 text-sm mt-1">Belum diproses</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-orange-100 rounded-xl p-3">
                    <i class="fas fa-spinner text-orange-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-orange-600">{{ $laporanDiproses }}</span>
            </div>
            <p class="text-gray-600 font-medium">Diproses</p>
            <p class="text-gray-400 text-sm mt-1">Sedang ditindaklanjuti</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-green-100 rounded-xl p-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-green-600">{{ $laporanSelesai }}</span>
            </div>
            <p class="text-gray-600 font-medium">Selesai</p>
            <p class="text-gray-400 text-sm mt-1">Telah ditangani</p>
        </div>
    </div>

    <!-- Recent Reports & Tips -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Recent Reports -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-md overflow-hidden">
            <div class="border-b px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-history mr-2 text-blue-500"></i>
                            Laporan Terbaru
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">5 laporan terakhir Anda</p>
                    </div>
                    <a href="{{ route('laporan.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                        Lihat Semua <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($laporanTerbaru->isEmpty())
                    <div class="text-center py-12">
                        <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-inbox text-4xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 mb-4">Belum ada laporan yang dibuat</p>
                        <a href="{{ route('laporan.create') }}" 
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg transition">
                            <i class="fas fa-plus"></i>
                            Buat Laporan Sekarang
                        </a>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($laporanTerbaru as $laporan)
                        <div class="group bg-gray-50 hover:bg-white rounded-lg p-4 transition-all duration-300 hover:shadow-md border border-transparent hover:border-blue-100">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2 flex-wrap">
                                        <h3 class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">
                                            {{ Str::limit($laporan->judul_laporan, 50) }}
                                        </h3>
                                        @if($laporan->status == 'pending')
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                                <i class="fas fa-clock mr-1 text-xs"></i> Menunggu
                                            </span>
                                        @elseif($laporan->status == 'diproses')
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                                <i class="fas fa-spinner mr-1 text-xs"></i> Diproses
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                                <i class="fas fa-check mr-1 text-xs"></i> Selesai
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap gap-4 text-sm">
                                        <span class="text-gray-500">
                                            <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                            {{ Str::limit($laporan->lokasi, 40) }}
                                        </span>
                                        <span class="text-gray-500">
                                            <i class="far fa-calendar-alt mr-1 text-gray-400"></i>
                                            {{ $laporan->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                                <a href="{{ route('laporan.show', $laporan->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 opacity-0 group-hover:opacity-100 transition-all duration-300 ml-4">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Tips & Informasi -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white">
                    <i class="fas fa-lightbulb mr-2"></i>
                    Tips & Informasi
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="bg-white rounded-full w-8 h-8 flex items-center justify-center shadow-sm">
                            <i class="fas fa-check-circle text-green-500 text-sm"></i>
                        </div>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Laporan yang jelas</p>
                        <p class="text-sm text-gray-600">Semakin detail laporan Anda, semakin cepat kami menindaklanjuti.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="bg-white rounded-full w-8 h-8 flex items-center justify-center shadow-sm">
                            <i class="fas fa-image text-blue-500 text-sm"></i>
                        </div>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Sertakan bukti</p>
                        <p class="text-sm text-gray-600">Lampirkan foto atau video untuk memperkuat laporan Anda.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="bg-white rounded-full w-8 h-8 flex items-center justify-center shadow-sm">
                            <i class="fas fa-bell text-orange-500 text-sm"></i>
                        </div>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Pantau terus</p>
                        <p class="text-sm text-gray-600">Cek status laporan Anda secara berkala di menu Pantau Aduan.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="bg-white rounded-full w-8 h-8 flex items-center justify-center shadow-sm">
                            <i class="fas fa-hand-peace text-purple-500 text-sm"></i>
                        </div>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Jadi Relawan</p>
                        <p class="text-sm text-gray-600">Daftar menjadi relawan untuk berkontribusi lebih untuk masyarakat.</p>
                    </div>
                </div>
            </div>
            <div class="px-6 pb-6">
                <a href="{{ route('relawan.create') }}" class="block text-center bg-white hover:bg-gray-50 text-blue-600 font-medium py-2 rounded-lg transition border border-blue-200">
                    <i class="fas fa-hands-helping mr-2"></i> Gabung Relawan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection