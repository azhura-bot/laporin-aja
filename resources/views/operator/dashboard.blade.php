@extends('layouts.operator')

@section('page-title', 'Dashboard Operator')
@section('page-description', 'Selamat datang di panel operator LaporinAja')

@section('operator-content')
<div class="fade-in">
    <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 rounded-2xl shadow-xl p-6 mb-8 text-white">
        <div class="absolute right-0 top-0 opacity-10">
            <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
            </svg>
        </div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-3">
                <i class="fas fa-map-marked-alt text-2xl"></i>
                <span class="text-blue-100">Overview</span>
            </div>
            <h1 class="text-2xl font-bold mb-1">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-blue-100">Kelola dan tindak lanjuti laporan yang ditugaskan kepada Anda.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-blue-100 rounded-xl p-3">
                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-blue-600">{{ $totalLaporan }}</span>
            </div>
            <p class="text-gray-600 font-medium">Total Tugas</p>
            <p class="text-gray-400 text-sm mt-1">Seluruh laporan yang ditugaskan</p>
            <div class="mt-3 pt-3 border-t">
                <span class="text-xs text-green-600">
                    <i class="fas fa-arrow-up"></i> {{ $laporanSelesai }} selesai
                </span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-yellow-100 rounded-xl p-3">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-yellow-600">{{ $laporanPending }}</span>
            </div>
            <p class="text-gray-600 font-medium">Pending</p>
            <p class="text-gray-400 text-sm mt-1">Menunggu diproses lapangan</p>
            <div class="mt-3 pt-3 border-t">
                <span class="text-xs text-yellow-600">
                    <i class="fas fa-clock"></i> Perlu tindakan
                </span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5">
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

        <div class="bg-white rounded-xl shadow-md p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-green-100 rounded-xl p-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-green-600">{{ $laporanSelesai }}</span>
            </div>
            <p class="text-gray-600 font-medium">Selesai</p>
            <p class="text-gray-400 text-sm mt-1">Penanganan sudah ditutup</p>
            <div class="mt-3 pt-3 border-t">
                <span class="text-xs text-green-600">
                    <i class="fas fa-check"></i> Completed
                </span>
            </div>
        </div>
    </div>

    <div class="bg-blue-50 border border-blue-100 rounded-xl shadow-sm p-5 mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="bg-white rounded-xl p-3 text-blue-600 shadow-sm">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Panduan Proses Laporan</h3>
                    <p class="text-sm text-gray-600 mt-1">Mulai dari status yang benar, isi catatan penanganan dengan jelas, lalu unggah bukti lapangan saat pekerjaan selesai.</p>
                </div>
            </div>
            <a href="{{ route('operator.laporan.index') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition text-sm font-semibold">
                Buka Laporan Saya
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <div class="border-b px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">
                        <i class="fas fa-clipboard-list mr-2 text-blue-500"></i>
                        Laporan Aktif
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Laporan pending dan diproses yang sedang Anda tangani</p>
                </div>
                <a href="{{ route('operator.laporan.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ditugaskan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($laporanAktif as $laporan)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">#{{ $laporan->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($laporan->judul_laporan, 42) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($laporan->lokasi, 40) }}</td>
                            <td class="px-6 py-4">
                                @if($laporan->status == 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Pending</span>
                                @elseif($laporan->status == 'diproses')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Diproses</span>
                                @else
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Selesai</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ optional($laporan->ditugaskan_at)->format('d/m/Y H:i') ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('operator.laporan.show', $laporan->id) }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">Tidak ada laporan aktif saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="border-b px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">
                        <i class="fas fa-history mr-2 text-blue-500"></i>
                        Riwayat Terbaru
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Laporan selesai terakhir dari akun operator Anda</p>
                </div>
                <a href="{{ route('operator.laporan.history') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Selesai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($riwayatTerbaru as $laporan)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">#{{ $laporan->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($laporan->judul_laporan, 42) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($laporan->lokasi, 40) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ optional($laporan->selesai_at)->format('d/m/Y H:i') ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('operator.laporan.history.show', $laporan->id) }}" class="px-3 py-2 border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-50 text-sm transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada riwayat laporan selesai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
