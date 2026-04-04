@extends('layouts.dashboard.dashboard')

@section('dashboard-content')
<div class="fade-in">
    <!-- Header Welcome -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 mb-8 text-white">
        <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="text-blue-100">Platform Pengaduan Masyarakat - LaporinAja</p>
    </div>

    <!-- Tombol Aksi Cepat -->
    <div class="grid md:grid-cols-2 gap-4 mb-8">
        <a href="{{ route('laporan.create') }}" 
           class="bg-white border-2 border-blue-600 rounded-xl p-4 hover:shadow-lg transition">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-plus-circle text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Buat Laporan Baru</h3>
                    <p class="text-sm text-gray-500">Laporkan masalah di lingkungan Anda</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('laporan.index') }}" 
           class="bg-white border-2 border-gray-300 rounded-xl p-4 hover:shadow-lg transition">
            <div class="flex items-center gap-4">
                <div class="bg-gray-100 rounded-full p-3">
                    <i class="fas fa-eye text-gray-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Pantau Aduan</h3>
                    <p class="text-sm text-gray-500">Lihat status laporan Anda</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-gray-500 text-sm">Total Laporan</p>
                <i class="fas fa-file-alt text-blue-500 text-xl"></i>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ $totalLaporan ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-gray-500 text-sm">Menunggu</p>
                <i class="fas fa-clock text-yellow-500 text-xl"></i>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ $laporanPending ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-gray-500 text-sm">Diproses</p>
                <i class="fas fa-spinner text-orange-500 text-xl"></i>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ $laporanDiproses ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-gray-500 text-sm">Selesai</p>
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ $laporanSelesai ?? 0 }}</p>
        </div>
    </div>

    <!-- Laporan Terbaru -->
    <div class="bg-white rounded-xl shadow">
        <div class="border-b px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-history mr-2 text-blue-500"></i>
                Laporan Terbaru
            </h2>
        </div>
        <div class="p-6">
            @if(isset($laporanTerbaru) && $laporanTerbaru->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 mb-4">Belum ada laporan yang dibuat</p>
                    <a href="{{ route('laporan.create') }}" 
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                        <i class="fas fa-plus mr-2"></i>Buat Laporan Sekarang
                    </a>
                </div>
            @elseif(isset($laporanTerbaru))
                <div class="space-y-3">
                    @foreach($laporanTerbaru as $laporan)
                    <div class="border rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2 flex-wrap">
                                    <h3 class="font-semibold text-gray-800">{{ $laporan->judul_laporan }}</h3>
                                    @if($laporan->status == 'pending')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Menunggu</span>
                                    @elseif($laporan->status == 'diproses')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Diproses</span>
                                    @else
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Selesai</span>
                                    @endif
                                </div>
                                <p class="text-gray-600 text-sm mb-1">
                                    <i class="fas fa-map-marker-alt mr-1"></i> {{ $laporan->lokasi }}
                                </p>
                                <p class="text-gray-400 text-xs">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ $laporan->created_at->format('d M Y H:i') }}
                                </p>
                            </div>
                            <a href="{{ route('laporan.show', $laporan->id) }}" class="text-blue-600 ml-4">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('laporan.index') }}" class="text-blue-600 text-sm">Lihat Semua Laporan →</a>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Belum ada laporan</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection