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
                <input type="date" name="tanggal_kejadian" value="{{ old('tanggal_kejadian', $laporan->tanggal_kejadian instanceof \Carbon\Carbon ? $laporan->tanggal_kejadian->format('Y-m-d') : date('Y-m-d', strtotime($laporan->tanggal_kejadian))) }}" 
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
                
                {{-- Tampilkan lampiran yang ada --}}
                @if($laporan->lampiran)
                    <div class="mb-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 mb-2">Lampiran saat ini:</p>
                        <div class="flex items-center gap-3">
                            {{-- Cek apakah file adalah gambar --}}
                            @php
                                $lampiranPath = $laporan->lampiran;
                                $lampiranUrl = $laporan->lampiran_url;
                                $isImage = $laporan->is_lampiran_image;
                                $resolvedPath = parse_url($lampiranPath, PHP_URL_PATH) ?: $lampiranPath;
                                $fileExtension = strtolower(pathinfo($resolvedPath, PATHINFO_EXTENSION));
                            @endphp
                            
                            @if($isImage)
                                <img src="{{ $lampiranUrl }}" 
                                     alt="Lampiran Saat Ini" 
                                     class="h-20 w-auto object-cover rounded border">
                            @else
                                @php
                                    $fileIcon = 'fa-file';
                                    if(in_array($fileExtension, ['pdf'])) $fileIcon = 'fa-file-pdf';
                                    elseif(in_array($fileExtension, ['doc', 'docx'])) $fileIcon = 'fa-file-word';
                                    elseif(in_array($fileExtension, ['xls', 'xlsx'])) $fileIcon = 'fa-file-excel';
                                    elseif(in_array($fileExtension, ['mp4', 'avi', 'mov', 'mkv'])) $fileIcon = 'fa-file-video';
                                    elseif(in_array($fileExtension, ['mp3', 'wav'])) $fileIcon = 'fa-file-audio';
                                @endphp
                                <i class="fas {{ $fileIcon }} text-3xl text-gray-500"></i>
                            @endif
                            
                            <div class="flex-1">
                                <p class="text-sm text-gray-700 break-all">
                                    <i class="fas fa-paperclip mr-1 text-gray-400"></i>
                                    {{ basename($lampiranPath) }}
                                </p>
                                <a href="{{ $lampiranUrl }}" 
                                   target="_blank" 
                                   class="text-blue-600 text-sm hover:underline inline-flex items-center gap-1 mt-1">
                                    <i class="fas fa-external-link-alt"></i> Lihat Lampiran
                                </a>
                            </div>
                            
                            {{-- Checkbox untuk menghapus lampiran --}}
                            <label class="flex items-center gap-2 text-sm text-red-600 cursor-pointer">
                                <input type="checkbox" name="hapus_lampiran" value="1" class="rounded border-gray-300">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </label>
                        </div>
                    </div>
                @endif
                
                {{-- Input upload file baru --}}
                <input type="file" name="lampiran" 
                       accept="image/*,video/*,.pdf,.doc,.docx"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                
                <div class="text-gray-500 text-sm mt-2 flex flex-wrap gap-3">
                    <span><i class="fas fa-info-circle mr-1"></i> Kosongkan jika tidak ingin mengubah lampiran</span>
                    <span><i class="fas fa-image mr-1"></i> Format: JPG, PNG, GIF, PDF, DOC</span>
                    <span><i class="fas fa-database mr-1"></i> Max: 5MB</span>
                </div>
                
                @error('lampiran') 
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                @enderror
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

<style>
    /* Preview gambar saat memilih file baru */
    .image-preview {
        display: none;
        margin-top: 10px;
    }
    
    .image-preview img {
        max-height: 150px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
</style>

<script>
    // Preview gambar sebelum upload
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.querySelector('input[name="lampiran"]');
        
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    // Hapus preview lama jika ada
                    let preview = document.querySelector('.image-preview');
                    if (!preview) {
                        preview = document.createElement('div');
                        preview.className = 'image-preview mt-3';
                        fileInput.parentNode.appendChild(preview);
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        preview.innerHTML = `
                            <p class="text-sm text-gray-600 mb-2">Preview gambar baru:</p>
                            <img src="${event.target.result}" class="h-32 w-auto rounded border">
                        `;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else if (fileInput.parentNode.querySelector('.image-preview')) {
                    fileInput.parentNode.querySelector('.image-preview').style.display = 'none';
                }
            });
        }
    });
</script>
@endsection
