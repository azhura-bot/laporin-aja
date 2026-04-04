@extends('layouts.dashboard.index')

@section('dashboard-content')
<div class="fade-in max-w-5xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Laporan</h1>
        <p class="text-gray-500">Informasi lengkap tentang laporan Anda</p>
    </div>

    <!-- Search Section - Grid 2 Column -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-10">
                <label class="block text-gray-700 text-sm font-medium mb-1">Masukan ID Laporan</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="searchId" placeholder="Contoh: LAP-2024-001" 
                           class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
            </div>
            <div class="md:col-span-2 flex items-end">
                <button id="btnSearch" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-search"></i>
                    <span>Cari</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Detail Laporan Card -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
        <!-- Status Badge -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">{{ $laporan->judul_laporan }}</h2>
                <span class="px-3 py-1 bg-yellow-500 text-white text-sm rounded-full">
                    <i class="fas fa-clock mr-1"></i> Dalam Proses
                </span>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- Informasi Laporan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-gray-500 text-sm">Tanggal Kejadian</p>
                    <p class="font-medium text-gray-800">{{ $laporan->tanggal_kejadian->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Lokasi</p>
                    <p class="font-medium text-gray-800">{{ $laporan->lokasi }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Kategori</p>
                    <p class="font-medium text-gray-800">{{ $laporan->kategori }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">ID Laporan</p>
                    <p class="font-medium text-gray-800">#{{ $laporan->id }}</p>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Laporan</h3>
                <div class="flex flex-wrap gap-4">
                    <div class="flex-1 text-center">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-paper-plane text-white"></i>
                        </div>
                        <p class="font-medium text-sm">Dikirim</p>
                        <p class="text-xs text-gray-500">{{ $laporan->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="flex-1 text-center">
                        <div class="w-12 h-12 {{ $laporan->status == 'diproses' || $laporan->status == 'selesai' ? 'bg-blue-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-spinner text-white"></i>
                        </div>
                        <p class="font-medium text-sm">Diproses</p>
                        <p class="text-xs text-gray-500">-</p>
                    </div>
                    <div class="flex-1 text-center">
                        <div class="w-12 h-12 {{ $laporan->status == 'selesai' ? 'bg-purple-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-tools text-white"></i>
                        </div>
                        <p class="font-medium text-sm">Ditindaklanjuti</p>
                        <p class="text-xs text-gray-500">-</p>
                    </div>
                    <div class="flex-1 text-center">
                        <div class="w-12 h-12 {{ $laporan->status == 'selesai' ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-check-circle text-white"></i>
                        </div>
                        <p class="font-medium text-sm">Selesai</p>
                        <p class="text-xs text-gray-500">-</p>
                    </div>
                </div>
            </div>

            <!-- Riwayat Laporan -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Laporan</h3>
                <div class="space-y-3">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">Laporan diterima</p>
                            <p class="text-sm text-gray-500">{{ $laporan->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-check text-blue-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">Diproses oleh Admin</p>
                            <p class="text-sm text-gray-500">{{ $laporan->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                    @if($laporan->status == 'selesai')
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-hard-hat text-purple-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">Diteruskan ke staf lapangan</p>
                            <p class="text-sm text-gray-500">-</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-double text-green-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">Perbaikan telah selesai</p>
                            <p class="text-sm text-gray-500">-</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Respon Admin -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Respon Admin</h3>
                <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-comment-dots text-blue-600 mt-0.5"></i>
                        <div>
                            <p class="text-gray-700">
                                @if($laporan->status == 'pending')
                                    Laporan Anda telah kami terima dan akan segera diproses.
                                @elseif($laporan->status == 'diproses')
                                    Kami sedang menindaklanjuti laporan Anda. Mohon ditunggu.
                                @else
                                    Laporan Anda telah selesai ditindaklanjuti. Terima kasih atas partisipasinya.
                                @endif
                            </p>
                            <p class="text-xs text-blue-600 mt-2">{{ $laporan->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-wrap gap-3 pt-4 border-t">
                <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-download"></i>
                    <span>Unduh Laporan</span>
                </button>
                <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i>
                    <span>Kirim Ulang</span>
                </button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tambah Informasi</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi pencarian berdasarkan ID
    document.getElementById('btnSearch').addEventListener('click', function() {
        const searchId = document.getElementById('searchId').value;
        if (searchId) {
            window.location.href = '/laporan/' + searchId;
        } else {
            alert('Masukkan ID Laporan terlebih dahulu');
        }
    });
    
    // Enter key untuk search
    document.getElementById('searchId').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('btnSearch').click();
        }
    });
</script>
@endsection