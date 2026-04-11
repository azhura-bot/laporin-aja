@extends('layouts.admin')

@section('page-title', 'Edit Daerah Butuh Relawan')
@section('page-description', 'Perbarui informasi daerah yang membutuhkan bantuan relawan')

@section('admin-content')
<div class="fade-in max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin.daerah-butuh-relawan.index') }}" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Daerah</h1>
                <p class="text-gray-500 text-sm">Perbarui informasi daerah {{ $daerah->nama_daerah }}</p>
            </div>
        </div>

        <form action="{{ route('admin.daerah-butuh-relawan.update', $daerah) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Daerah -->
            <div>
                <label class="block text-gray-700 mb-2 font-medium">Nama Daerah <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                    </div>
                    <input type="text" name="nama_daerah" value="{{ old('nama_daerah', $daerah->nama_daerah) }}"
                           class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                           placeholder="Contoh: Jakarta Pusat" required>
                </div>
                @error('nama_daerah') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Provinsi -->
            <div>
                <label class="block text-gray-700 mb-2 font-medium">Provinsi <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-flag text-gray-400"></i>
                    </div>
                    <select name="provinsi" class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 appearance-none" required>
                        <option value="">Pilih Provinsi</option>
                        <option value="Aceh" {{ old('provinsi', $daerah->provinsi) == 'Aceh' ? 'selected' : '' }}>Aceh</option>
                        <option value="Sumatera Utara" {{ old('provinsi', $daerah->provinsi) == 'Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara</option>
                        <option value="Sumatera Barat" {{ old('provinsi', $daerah->provinsi) == 'Sumatera Barat' ? 'selected' : '' }}>Sumatera Barat</option>
                        <option value="Riau" {{ old('provinsi', $daerah->provinsi) == 'Riau' ? 'selected' : '' }}>Riau</option>
                        <option value="Jambi" {{ old('provinsi', $daerah->provinsi) == 'Jambi' ? 'selected' : '' }}>Jambi</option>
                        <option value="Sumatera Selatan" {{ old('provinsi', $daerah->provinsi) == 'Sumatera Selatan' ? 'selected' : '' }}>Sumatera Selatan</option>
                        <option value="Bengkulu" {{ old('provinsi', $daerah->provinsi) == 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                        <option value="Lampung" {{ old('provinsi', $daerah->provinsi) == 'Lampung' ? 'selected' : '' }}>Lampung</option>
                        <option value="Kepulauan Bangka Belitung" {{ old('provinsi', $daerah->provinsi) == 'Kepulauan Bangka Belitung' ? 'selected' : '' }}>Kepulauan Bangka Belitung</option>
                        <option value="Kepulauan Riau" {{ old('provinsi', $daerah->provinsi) == 'Kepulauan Riau' ? 'selected' : '' }}>Kepulauan Riau</option>
                        <option value="DKI Jakarta" {{ old('provinsi', $daerah->provinsi) == 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                        <option value="Jawa Barat" {{ old('provinsi', $daerah->provinsi) == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                        <option value="Jawa Tengah" {{ old('provinsi', $daerah->provinsi) == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                        <option value="DI Yogyakarta" {{ old('provinsi', $daerah->provinsi) == 'DI Yogyakarta' ? 'selected' : '' }}>DI Yogyakarta</option>
                        <option value="Jawa Timur" {{ old('provinsi', $daerah->provinsi) == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                        <option value="Banten" {{ old('provinsi', $daerah->provinsi) == 'Banten' ? 'selected' : '' }}>Banten</option>
                        <option value="Bali" {{ old('provinsi', $daerah->provinsi) == 'Bali' ? 'selected' : '' }}>Bali</option>
                        <option value="Nusa Tenggara Barat" {{ old('provinsi', $daerah->provinsi) == 'Nusa Tenggara Barat' ? 'selected' : '' }}>Nusa Tenggara Barat</option>
                        <option value="Nusa Tenggara Timur" {{ old('provinsi', $daerah->provinsi) == 'Nusa Tenggara Timur' ? 'selected' : '' }}>Nusa Tenggara Timur</option>
                        <option value="Kalimantan Barat" {{ old('provinsi', $daerah->provinsi) == 'Kalimantan Barat' ? 'selected' : '' }}>Kalimantan Barat</option>
                        <option value="Kalimantan Tengah" {{ old('provinsi', $daerah->provinsi) == 'Kalimantan Tengah' ? 'selected' : '' }}>Kalimantan Tengah</option>
                        <option value="Kalimantan Selatan" {{ old('provinsi', $daerah->provinsi) == 'Kalimantan Selatan' ? 'selected' : '' }}>Kalimantan Selatan</option>
                        <option value="Kalimantan Timur" {{ old('provinsi', $daerah->provinsi) == 'Kalimantan Timur' ? 'selected' : '' }}>Kalimantan Timur</option>
                        <option value="Kalimantan Utara" {{ old('provinsi', $daerah->provinsi) == 'Kalimantan Utara' ? 'selected' : '' }}>Kalimantan Utara</option>
                        <option value="Sulawesi Utara" {{ old('provinsi', $daerah->provinsi) == 'Sulawesi Utara' ? 'selected' : '' }}>Sulawesi Utara</option>
                        <option value="Sulawesi Tengah" {{ old('provinsi', $daerah->provinsi) == 'Sulawesi Tengah' ? 'selected' : '' }}>Sulawesi Tengah</option>
                        <option value="Sulawesi Selatan" {{ old('provinsi', $daerah->provinsi) == 'Sulawesi Selatan' ? 'selected' : '' }}>Sulawesi Selatan</option>
                        <option value="Sulawesi Tenggara" {{ old('provinsi', $daerah->provinsi) == 'Sulawesi Tenggara' ? 'selected' : '' }}>Sulawesi Tenggara</option>
                        <option value="Gorontalo" {{ old('provinsi', $daerah->provinsi) == 'Gorontalo' ? 'selected' : '' }}>Gorontalo</option>
                        <option value="Sulawesi Barat" {{ old('provinsi', $daerah->provinsi) == 'Sulawesi Barat' ? 'selected' : '' }}>Sulawesi Barat</option>
                        <option value="Maluku" {{ old('provinsi', $daerah->provinsi) == 'Maluku' ? 'selected' : '' }}>Maluku</option>
                        <option value="Maluku Utara" {{ old('provinsi', $daerah->provinsi) == 'Maluku Utara' ? 'selected' : '' }}>Maluku Utara</option>
                        <option value="Papua Barat" {{ old('provinsi', $daerah->provinsi) == 'Papua Barat' ? 'selected' : '' }}>Papua Barat</option>
                        <option value="Papua" {{ old('provinsi', $daerah->provinsi) == 'Papua' ? 'selected' : '' }}>Papua</option>
                        <option value="Papua Selatan" {{ old('provinsi', $daerah->provinsi) == 'Papua Selatan' ? 'selected' : '' }}>Papua Selatan</option>
                        <option value="Papua Tengah" {{ old('provinsi', $daerah->provinsi) == 'Papua Tengah' ? 'selected' : '' }}>Papua Tengah</option>
                        <option value="Papua Pegunungan" {{ old('provinsi', $daerah->provinsi) == 'Papua Pegunungan' ? 'selected' : '' }}>Papua Pegunungan</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
                @error('provinsi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-gray-700 mb-2 font-medium">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                          placeholder="Jelaskan kondisi daerah dan jenis bantuan yang dibutuhkan...">{{ old('deskripsi', $daerah->deskripsi) }}</textarea>
                @error('deskripsi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Prioritas -->
            <div>
                <label class="block text-gray-700 mb-2 font-medium">Tingkat Prioritas <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <label class="relative">
                        <input type="radio" name="prioritas" value="rendah" {{ old('prioritas', $daerah->prioritas) == 'rendah' ? 'checked' : '' }} class="sr-only peer" required>
                        <div class="p-3 border border-gray-300 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 hover:bg-gray-50 transition">
                            <div class="text-center">
                                <i class="fas fa-info-circle text-green-600 text-lg mb-1"></i>
                                <div class="text-sm font-medium text-gray-700">Rendah</div>
                            </div>
                        </div>
                    </label>
                    <label class="relative">
                        <input type="radio" name="prioritas" value="sedang" {{ old('prioritas', $daerah->prioritas) == 'sedang' ? 'checked' : '' }} class="sr-only peer" required>
                        <div class="p-3 border border-gray-300 rounded-lg cursor-pointer peer-checked:border-yellow-500 peer-checked:bg-yellow-50 hover:bg-gray-50 transition">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle text-yellow-600 text-lg mb-1"></i>
                                <div class="text-sm font-medium text-gray-700">Sedang</div>
                            </div>
                        </div>
                    </label>
                    <label class="relative">
                        <input type="radio" name="prioritas" value="tinggi" {{ old('prioritas', $daerah->prioritas) == 'tinggi' ? 'checked' : '' }} class="sr-only peer" required>
                        <div class="p-3 border border-gray-300 rounded-lg cursor-pointer peer-checked:border-orange-500 peer-checked:bg-orange-50 hover:bg-gray-50 transition">
                            <div class="text-center">
                                <i class="fas fa-exclamation-circle text-orange-600 text-lg mb-1"></i>
                                <div class="text-sm font-medium text-gray-700">Tinggi</div>
                            </div>
                        </div>
                    </label>
                    <label class="relative">
                        <input type="radio" name="prioritas" value="kritis" {{ old('prioritas', $daerah->prioritas) == 'kritis' ? 'checked' : '' }} class="sr-only peer" required>
                        <div class="p-3 border border-gray-300 rounded-lg cursor-pointer peer-checked:border-red-500 peer-checked:bg-red-50 hover:bg-gray-50 transition">
                            <div class="text-center">
                                <i class="fas fa-radiation text-red-600 text-lg mb-1"></i>
                                <div class="text-sm font-medium text-gray-700">Kritis</div>
                            </div>
                        </div>
                    </label>
                </div>
                @error('prioritas') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Jumlah Relawan Dibutuhkan -->
            <div>
                <label class="block text-gray-700 mb-2 font-medium">Jumlah Relawan Dibutuhkan <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-users text-gray-400"></i>
                    </div>
                    <input type="number" name="relawan_dibutuhkan" value="{{ old('relawan_dibutuhkan', $daerah->relawan_dibutuhkan) }}" min="1"
                           class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                           placeholder="10" required>
                </div>
                @error('relawan_dibutuhkan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Status Aktif -->
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="aktif" value="1" {{ old('aktif', $daerah->aktif) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-gray-700">Aktifkan daerah ini untuk ditampilkan di halaman publik</span>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg transition font-medium">
                    <i class="fas fa-save mr-2"></i>
                    Update Daerah
                </button>
                <a href="{{ route('admin.daerah-butuh-relawan.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection