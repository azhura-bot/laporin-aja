@extends('layouts.admin')

@section('page-title', 'Dashboard Admin')
@section('page-description', 'Selamat datang di panel administrasi LaporinAja')

@section('admin-content')
<div class="fade-in">
    <!-- Welcome Section -->
    <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 rounded-2xl shadow-xl p-6 mb-8 text-white">
        <div class="absolute right-0 top-0 opacity-10">
            <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
            </svg>
        </div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-3">
                <i class="fas fa-chart-line text-2xl"></i>
                <span class="text-blue-100">Overview</span>
            </div>
            <h1 class="text-2xl font-bold mb-1">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-blue-100">Pantau dan kelola seluruh laporan masyarakat di sini.</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-5 card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-blue-100 rounded-xl p-3">
                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-blue-600">{{ $totalLaporan }}</span>
            </div>
            <p class="text-gray-600 font-medium">Total Laporan</p>
            <p class="text-gray-400 text-sm mt-1">Seluruh laporan masuk</p>
            <div class="mt-3 pt-3 border-t">
                <span class="text-xs text-green-600">
                    <i class="fas fa-arrow-up"></i> +{{ $laporanSelesai }} selesai
                </span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-yellow-100 rounded-xl p-3">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-yellow-600">{{ $laporanPending }}</span>
            </div>
            <p class="text-gray-600 font-medium">Menunggu</p>
            <p class="text-gray-400 text-sm mt-1">Belum diproses</p>
            <div class="mt-3 pt-3 border-t">
                                <span class="text-xs text-yellow-600">
                                    <i class="fas fa-clock"></i> Perlu tindakan
                                </span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-orange-100 rounded-xl p-3">
                    <i class="fas fa-spinner text-orange-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-orange-600">{{ $laporanDiproses }}</span>
            </div>
            <p class="text-gray-600 font-medium">Diproses</p>
            <p class="text-gray-400 text-sm mt-1">Sedang ditindaklanjuti</p>
            <div class="mt-3 pt-3 border-t">
                <span class="text-xs text-orange-600">
                    <i class="fas fa-tasks"></i> On progress
                </span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 card-hover">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-green-100 rounded-xl p-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-green-600">{{ $laporanSelesai }}</span>
            </div>
            <p class="text-gray-600 font-medium">Selesai</p>
            <p class="text-gray-400 text-sm mt-1">Telah ditangani</p>
            <div class="mt-3 pt-3 border-t">
                <span class="text-xs text-green-600">
                    <i class="fas fa-check"></i> Completed
                </span>
            </div>
        </div>
    </div>

    <!-- Relawan & Users Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-5 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-500 text-sm">Total Relawan</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $totalRelawan }}</p>
                </div>
                <div class="bg-purple-100 rounded-xl p-3">
                    <i class="fas fa-hands-helping text-purple-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-yellow-600">Menunggu: {{ $relawanPending }}</span>
                <span class="text-green-600">Aktif: {{ $relawanAktif }}</span>
            </div>
            <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                @php
                    $persenAktif = $totalRelawan > 0 ? ($relawanAktif / $totalRelawan) * 100 : 0;
                @endphp
                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $persenAktif }}%"></div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-500 text-sm">Total Warga Terdaftar</p>
                    <p class="text-3xl font-bold text-teal-600">{{ $totalUsers }}</p>
                </div>
                <div class="bg-teal-100 rounded-xl p-3">
                    <i class="fas fa-users text-teal-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-blue-600">Aktif: {{ $totalUsers }}</span>
                <span class="text-gray-400">Bergabung: {{ $totalUsers }}</span>
            </div>
            <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                <div class="bg-teal-500 h-2 rounded-full" style="width: 100%"></div>
            </div>
        </div>
    </div>

    <!-- Laporan Terbaru -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="border-b px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">
                        <i class="fas fa-history mr-2 text-blue-500"></i>
                        Laporan Terbaru
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">10 laporan terakhir yang masuk</p>
                </div>
                <a href="{{ route('admin.laporan.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                    Lihat Semua <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul Laporan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelapor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($laporanTerbaru as $laporan)
                    <tr onclick="window.location='{{ route('admin.laporan.show', $laporan->id) }}'" class="hover:bg-gray-50 transition cursor-pointer">
                        <td class="px-6 py-4 text-sm text-gray-900">#{{ $laporan->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($laporan->judul_laporan, 40) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $laporan->nama_pelapor }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $laporan->kategori }}</td>
                        <td class="px-6 py-4">
                            @if($laporan->status == 'pending')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Menunggu</span>
                            @elseif($laporan->status == 'diproses')
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Diproses</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Selesai</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $laporan->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection