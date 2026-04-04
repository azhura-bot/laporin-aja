@extends('layouts.dashboard.index')

@section('dashboard-content')
<div class="fade-in max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Laporan</h1>
        <a href="{{ route('laporan.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-1"></i>Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">{{ $laporan->judul_laporan }}</h2>
                {!! $laporan->status_badge !!}
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- Data Pelapor -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-3">Data Pelapor</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-500 text-sm">Nama</p>
                        <p class="font-medium">{{ $laporan->nama_pelapor }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">No. HP</p>
                        <p class="font-medium">{{ $laporan->no_hp }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Email</p>
                        <p class="font-medium">{{ $laporan->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Detail Pengaduan -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-3">Detail Pengaduan</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-gray-500 text-sm">Kategori</p>
                        <p class="font-medium">{{ $laporan->kategori }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Lokasi Kejadian</p>
                        <p class="font-medium">{{ $laporan->lokasi }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Tanggal Kejadian</p>
                        <p class="font-medium">{{ $laporan->tanggal_kejadian->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Deskripsi</p>
                        <p class="text-gray-700">{{ $laporan->deskripsi }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Tanggal Laporan</p>
                        <p class="font-medium">{{ $laporan->created_at->format('d F Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Lampiran -->
            @if($laporan->lampiran)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-3">Lampiran Bukti</h3>
                @if($laporan->is_lampiran_image)
                    <img src="{{ $laporan->lampiran_url }}" alt="Lampiran" class="max-w-full rounded-lg shadow">
                @else
                    <a href="{{ $laporan->lampiran_url }}" target="_blank" class="text-blue-600 hover:underline">
                        <i class="fas fa-download mr-1"></i>Download Lampiran
                    </a>
                @endif
            </div>
            @endif

            <!-- Actions -->
            @if($laporan->status == 'pending')
            <div class="flex gap-3 pt-4 border-t">
                <a href="{{ route('laporan.edit', $laporan->id) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-edit mr-1"></i>Edit Laporan
                </a>
                <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-trash mr-1"></i>Hapus Laporan
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection