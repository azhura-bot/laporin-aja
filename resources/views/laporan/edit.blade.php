@extends('layouts.dashboard.index')

@section('dashboard-content')
<div class="fade-in max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Laporan</h1>

    <form action="{{ route('laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        <!-- Data Pelapor -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Data Pelapor</h2>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Masukan Nama <span class="text-red-500">*</span></label>
                <input type="text" name="nama_pelapor" value="{{ old('nama_pelapor', $laporan->nama_pelapor) }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>
                @error('nama_pelapor') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">No. Hp <span class="text-red-500">*</span></label>
                <input type="tel" name="no_hp" value="{{ old('no_hp', $laporan->no_hp) }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>
                @error('no_hp') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $laporan->email) }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Detail Pengaduan -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Detail Pengaduan</h2>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Kategori Pengaduan <span class="text-red-500">*</span></label>
                <select name="kategori" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriList as $value => $label)
                        <option value="{{ $value }}" {{ old('kategori', $laporan->kategori) == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('kategori') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Lokasi Kejadian <span class="text-red-500">*</span></label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $laporan->lokasi) }}" 
                       placeholder="Masukan Lokasi Kejadian"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>
                @error('lokasi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tanggal Kejadian <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_kejadian" value="{{ old('tanggal_kejadian', $laporan->tanggal_kejadian->format('Y-m-d')) }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>
                @error('tanggal_kejadian') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Judul Laporan <span class="text-red-500">*</span></label>
                <input type="text" name="judul_laporan" value="{{ old('judul_laporan', $laporan->judul_laporan) }}" 
                       placeholder="Judul Laporan"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>
                @error('judul_laporan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Deskripsi Pengaduan <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="5" 
                          placeholder="Jelaskan Masalah apa yang terjadi"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
                @error('deskripsi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Lampiran Bukti (Foto/Video/Dokumen)</label>
                @if($laporan->lampiran)
                    <div class="mb-2 p-2 bg-gray-100 rounded">
                        <p class="text-sm text-gray-600">Lampiran saat ini:</p>
                        @if($laporan->is_lampiran_image)
                            <img src="{{ $laporan->lampiran_url }}" class="h-20 w-auto mt-1">
                        @else
                            <a href="{{ $laporan->lampiran_url }}" target="_blank" class="text-blue-600 text-sm">Lihat Lampiran</a>
                        @endif
                    </div>
                @endif
                <input type="file" name="lampiran" 
                       accept="image/*,video/*,.pdf,.doc,.docx"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500">
                <p class="text-gray-500 text-sm mt-1">Kosongkan jika tidak ingin mengubah lampiran. Max 5MB (JPG, PNG, PDF, DOC)</p>
                @error('lampiran') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-save mr-2"></i>Update Laporan
            </button>
            <a href="{{ route('laporan.show', $laporan->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection