@extends('layouts.admin')

@section('page-title', 'Detail Laporan')
@section('page-description', 'Informasi lengkap laporan masyarakat')

@section('admin-content')
<div class="fade-in max-w-4xl mx-auto">
    <!-- Tombol Kembali -->
    <div class="mb-6">
        <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Semua Laporan
        </a>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold text-white">{{ $laporan->judul_laporan }}</h1>
                @if($laporan->status == 'pending')
                    <span class="px-3 py-1 bg-yellow-500 text-white text-sm rounded-full">
                        <i class="fas fa-clock mr-1"></i> Menunggu
                    </span>
                @elseif($laporan->status == 'diproses')
                    <span class="px-3 py-1 bg-blue-500 text-white text-sm rounded-full">
                        <i class="fas fa-spinner mr-1"></i> Diproses
                    </span>
                @else
                    <span class="px-3 py-1 bg-green-500 text-white text-sm rounded-full">
                        <i class="fas fa-check mr-1"></i> Selesai
                    </span>
                @endif
            </div>
        </div>

        <div class="p-6">
            <!-- Informasi Pelapor -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">
                    <i class="fas fa-user mr-2 text-blue-500"></i>
                    Informasi Pelapor
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama Lengkap</p>
                        <p class="font-medium text-gray-800">{{ $laporan->nama_pelapor }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nomor Telepon</p>
                        <p class="font-medium text-gray-800">{{ $laporan->no_hp }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-gray-800">{{ $laporan->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">ID Laporan</p>
                        <p class="font-medium text-gray-800">#{{ $laporan->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Detail Pengaduan -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                    Detail Pengaduan
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Kategori</p>
                        <p class="font-medium text-gray-800">{{ $laporan->kategori }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Kejadian</p>
                        <p class="font-medium text-gray-800">{{ $laporan->tanggal_kejadian->format('d F Y') }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Lokasi Kejadian</p>
                        <p class="font-medium text-gray-800">{{ $laporan->lokasi }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Deskripsi</p>
                        <p class="text-gray-700 leading-relaxed">{{ $laporan->deskripsi }}</p>
                    </div>
                </div>
            </div>

            <!-- Lampiran -->
            @if($laporan->lampiran)
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">
                    <i class="fas fa-paperclip mr-2 text-blue-500"></i>
                    Lampiran Bukti
                </h2>
                @if($laporan->is_lampiran_image)
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <img src="{{ $laporan->lampiran_url }}" alt="Lampiran" class="max-w-full max-h-96 mx-auto rounded-lg">
                    </div>
                @else
                    <a href="{{ $laporan->lampiran_url }}" target="_blank" 
                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-download"></i>
                        Download Lampiran
                    </a>
                @endif
            </div>
            @endif

            <!-- Timeline -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">
                    <i class="fas fa-history mr-2 text-blue-500"></i>
                    Timeline Laporan
                </h2>
                <div class="space-y-3">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Laporan Diterima</p>
                            <p class="text-sm text-gray-500">{{ $laporan->created_at->format('d F Y H:i:s') }}</p>
                        </div>
                    </div>
                    @if($laporan->status != 'pending')
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-spinner text-blue-600 text-sm"></i>
                            </div>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Laporan Diproses</p>
                            <p class="text-sm text-gray-500">{{ $laporan->updated_at->format('d F Y H:i:s') }}</p>
                        </div>
                    </div>
                    @endif
                    @if($laporan->status == 'selesai')
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-double text-green-600 text-sm"></i>
                            </div>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Laporan Selesai</p>
                            <p class="text-sm text-gray-500">{{ $laporan->updated_at->format('d F Y H:i:s') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Aksi -->
            <div class="flex gap-3 pt-4 border-t">
                <button onclick="changeStatus({{ $laporan->id }}, '{{ $laporan->status }}')" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-tasks mr-2"></i>Ubah Status
                </button>
                <form action="{{ route('admin.laporan.destroy', $laporan->id) }}" method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-trash mr-2"></i>Hapus Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ubah Status -->
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-96 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Ubah Status Laporan</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="statusForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                    <option value="pending">Menunggu</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition">
                    Simpan
                </button>
                <button type="button" onclick="closeModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 rounded-lg transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentLaporanId = null;
    
    function changeStatus(id, currentStatus) {
        currentLaporanId = id;
        const modal = document.getElementById('statusModal');
        const form = document.getElementById('statusForm');
        const select = form.querySelector('select');
        
        select.value = currentStatus;
        form.action = `/admin/laporan/${id}/status`;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeModal() {
        const modal = document.getElementById('statusModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    document.getElementById('statusModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endsection