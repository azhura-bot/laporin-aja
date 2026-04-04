@extends('layouts.dashboard.index')

@section('dashboard-content')
<div class="fade-in max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Buat Laporan Masalah</h1>

    <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf

        <!-- Data Pelapor -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Data Pelapor</h2>
            
            <!-- Grid 1 kolom untuk Nama -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Masukan Nama <span class="text-red-500">*</span></label>
                <input type="text" name="nama_pelapor" value="{{ old('nama_pelapor') }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>
                @error('nama_pelapor') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Grid 2 kolom: No HP dan Email -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2">No. Hp <span class="text-red-500">*</span></label>
                    <input type="tel" name="no_hp" value="{{ old('no_hp') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>
                    @error('no_hp') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Detail Pengaduan -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Detail Pengaduan</h2>

            <!-- Grid Pilih Kategori (1 kolom) -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Kategori Pengaduan <span class="text-red-500">*</span></label>
                <select name="kategori" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriList as $value => $label)
                        <option value="{{ $value }}" {{ old('kategori') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('kategori') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Grid 2 kolom: Lokasi dan Tanggal Kejadian -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2">Lokasi Kejadian <span class="text-red-500">*</span></label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" 
                           placeholder="Masukan Lokasi Kejadian"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>
                    @error('lokasi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Tanggal Kejadian <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>
                    @error('tanggal_kejadian') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Grid Full: Judul Laporan (1 kolom) -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Judul Laporan <span class="text-red-500">*</span></label>
                <input type="text" name="judul_laporan" value="{{ old('judul_laporan') }}" 
                       placeholder="Judul Laporan"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>
                @error('judul_laporan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Grid Textarea: Deskripsi (1 kolom) -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Deskripsi Pengaduan <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="5" 
                          placeholder="Jelaskan Masalah apa yang terjadi"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Grid Lampiran (1 kolom) -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Lampiran Bukti (Foto/Video/Dokumen)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition">
                    <input type="file" name="lampiran" id="lampiran" class="hidden" 
                           accept="image/*,video/*,.pdf,.doc,.docx">
                    <label for="lampiran" class="cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-500">Klik atau drag file ke sini</p>
                        <p class="text-gray-400 text-sm mt-1">Max 5MB (JPG, PNG, PDF, DOC)</p>
                    </label>
                </div>
                <div id="fileInfo" class="mt-2 hidden">
                    <div class="bg-blue-50 rounded-lg p-2 flex items-center gap-2">
                        <i class="fas fa-file text-blue-600"></i>
                        <span id="fileName" class="text-sm text-gray-600"></span>
                        <button type="button" onclick="clearFile()" class="ml-auto text-red-500 hover:text-red-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @error('lampiran') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex gap-3 pt-4 border-t">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-paper-plane mr-2"></i>Kirim Laporan
            </button>
            <a href="{{ route('laporan.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<script>
    // Script untuk menampilkan nama file yang dipilih
    document.getElementById('lampiran').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        
        if (file) {
            fileName.textContent = file.name;
            fileInfo.classList.remove('hidden');
        } else {
            fileInfo.classList.add('hidden');
        }
    });
    
    function clearFile() {
        document.getElementById('lampiran').value = '';
        document.getElementById('fileInfo').classList.add('hidden');
    }
</script>
@endsection