@extends('layouts.dashboard.index')

@section('dashboard-content')
<div class="fade-in max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Gabung Menjadi Relawan</h1>
    <p class="text-gray-500 mb-6">Isi formulir di bawah ini untuk mendaftar sebagai relawan</p>

    <form action="{{ route('relawan.store') }}" method="POST" class="bg-white rounded-xl shadow-lg p-6">
        @csrf

        <!-- Informasi Pribadi -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4 flex items-center gap-2">
                <i class="fas fa-user-circle text-blue-600"></i>
                Informasi Pribadi
            </h2>
            
            <!-- Grid 2 kolom: Nama dan Email -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">Nama Lengkap <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', Auth::user()->name) }}" 
                               class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                               placeholder="Masukkan nama lengkap" required>
                    </div>
                    @error('nama_lengkap') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">Email <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                               class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                               placeholder="email@example.com" required>
                    </div>
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Grid 2 kolom: No HP dan Domisili -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">Nomor Telepon <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input type="tel" name="no_hp" value="{{ old('no_hp') }}" 
                               class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                               placeholder="0812-3456-7890" required>
                    </div>
                    @error('no_hp') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2 font-medium">Domisili <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                        </div>
                        <input type="text" name="domisili" value="{{ old('domisili') }}" 
                               class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                               placeholder="Kota/Kabupaten tempat tinggal" required>
                    </div>
                    @error('domisili') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Keahlian/Bidang -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2 font-medium">Keahlian / Bidang <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tools text-gray-400"></i>
                    </div>
                    <select name="keahlian" class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 appearance-none" required>
                        <option value="">Pilih Keahlian/Bidang</option>
                        <option value="Kesehatan" {{ old('keahlian') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan (Dokter, Perawat, Tenaga Medis)</option>
                        <option value="Pendidikan" {{ old('keahlian') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan (Guru, Tutor, Pengajar)</option>
                        <option value="Teknik" {{ old('keahlian') == 'Teknik' ? 'selected' : '' }}>Teknik (Bangunan, Listrik, Mekanik)</option>
                        <option value="Sosial" {{ old('keahlian') == 'Sosial' ? 'selected' : '' }}>Sosial & Kemasyarakatan</option>
                        <option value="Lingkungan" {{ old('keahlian') == 'Lingkungan' ? 'selected' : '' }}>Lingkungan & Kebersihan</option>
                        <option value="IT" {{ old('keahlian') == 'IT' ? 'selected' : '' }}>Teknologi Informasi (IT)</option>
                        <option value="Hukum" {{ old('keahlian') == 'Hukum' ? 'selected' : '' }}>Hukum & Advokasi</option>
                        <option value="Logistik" {{ old('keahlian') == 'Logistik' ? 'selected' : '' }}>Logistik & Distribusi</option>
                        <option value="Lainnya" {{ old('keahlian') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
                @error('keahlian') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Motivasi -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4 flex items-center gap-2">
                <i class="fas fa-heart text-red-500"></i>
                Motivasi Bergabung
            </h2>
            <div class="relative">
                <div class="absolute top-3 left-3 pointer-events-none">
                    <i class="fas fa-quote-left text-gray-400"></i>
                </div>
                <textarea name="motivasi" rows="5" 
                          placeholder="Ceritakan mengapa Anda ingin bergabung menjadi relawan, apa yang memotivasi Anda, dan bagaimana Anda dapat berkontribusi untuk masyarakat..."
                          class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ old('motivasi') }}</textarea>
            </div>
            <p class="text-gray-400 text-xs mt-1">* Tuliskan motivasi Anda dengan jelas (minimal 20 karakter)</p>
            @error('motivasi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Syarat dan Ketentuan -->
        <div class="mb-6">
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex items-start gap-3">
                    <input type="checkbox" name="syarat_setuju" id="syarat_setuju" value="1" 
                           class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" required>
                    <label for="syarat_setuju" class="text-gray-700 text-sm leading-relaxed cursor-pointer">
                        Saya menyetujui syarat dan ketentuan yang berlaku serta bersedia menjadi bagian dari tim relawan.
                    </label>
                </div>
                @error('syarat_setuju') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Informasi Tambahan -->
        <div class="bg-blue-50 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                <div class="text-sm text-blue-800">
                    <p class="font-medium mb-1">Informasi Penting:</p>
                    <ul class="list-disc list-inside space-y-1 text-blue-700">
                        <li>Data Anda akan kami verifikasi terlebih dahulu</li>
                        <li>Relawan yang terverifikasi akan mendapatkan sertifikat</li>
                        <li>Anda akan mendapatkan notifikasi jika ada kegiatan</li>
                        <li>Data Anda aman dan tidak akan disalahgunakan</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex gap-3 pt-4 border-t">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-paper-plane"></i>
                <span>Daftar Jadi Relawan</span>
            </button>
            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </a>
        </div>
    </form>
</div>

<script>
    // Validasi minimal 20 karakter untuk motivasi (opsional)
    document.querySelector('form').addEventListener('submit', function(e) {
        const motivasi = document.querySelector('textarea[name="motivasi"]');
        if (motivasi.value.length > 0 && motivasi.value.length < 20) {
            e.preventDefault();
            alert('Motivasi harus minimal 20 karakter');
            motivasi.focus();
        }
    });
</script>
@endsection