@extends('layouts.admin')

@section('page-title', 'Daerah Butuh Relawan')
@section('page-description', 'Kelola daerah yang membutuhkan bantuan relawan')

@section('admin-content')
<div class="fade-in">
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Daerah</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalDaerah }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-map-marked-alt text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Daerah Aktif</p>
                    <p class="text-2xl font-bold text-green-600">{{ $daerahAktif }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Prioritas Kritis</p>
                    <p class="text-2xl font-bold text-red-600">{{ $daerahKritis }}</p>
                </div>
                <div class="bg-red-100 rounded-full p-3">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Relawan Dibutuhkan</p>
                    <p class="text-2xl font-bold text-orange-600">
                        {{ $daerahList->sum('relawan_tersedia') }}
                    </p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <i class="fas fa-users text-orange-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('admin.daerah-butuh-relawan.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nama daerah, provinsi..."
                           class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                <select name="provinsi" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 text-sm">
                    <option value="">Semua Provinsi</option>
                    @foreach($provinsiList as $provinsi)
                        <option value="{{ $provinsi }}" {{ request('provinsi') == $provinsi ? 'selected' : '' }}>{{ $provinsi }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                <select name="prioritas" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 text-sm">
                    <option value="semua" {{ request('prioritas') == 'semua' ? 'selected' : '' }}>Semua Prioritas</option>
                    <option value="kritis" {{ request('prioritas') == 'kritis' ? 'selected' : '' }}>Kritis</option>
                    <option value="tinggi" {{ request('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                    <option value="sedang" {{ request('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="rendah" {{ request('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 text-sm">
                    <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition text-sm">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>
                <a href="{{ route('admin.daerah-butuh-relawan.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition text-sm ml-2">
                    <i class="fas fa-undo-alt mr-1"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Header with Add Button -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="border-b px-6 py-3 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-map-marked-alt mr-2 text-blue-500"></i>
                Daftar Daerah Butuh Relawan
            </h2>
            <a href="{{ route('admin.daerah-butuh-relawan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition text-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Daerah
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Daerah</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Provinsi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Prioritas</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Relawan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($daerahList as $daerah)
                    <tr onclick="window.location='{{ route('admin.daerah-butuh-relawan.show', $daerah->id) }}'" class="hover:bg-gray-50 transition cursor-pointer">
                        <td class="px-4 py-3">
                            <div>
                                <p class="font-medium text-gray-800">{{ $daerah->nama_daerah }}</p>
                                @if($daerah->deskripsi)
                                    <p class="text-xs text-gray-500 mt-1">{{ Str::limit($daerah->deskripsi, 50) }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $daerah->provinsi }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 {{ $daerah->prioritas_badge }} text-xs rounded-full font-medium">
                                {{ $daerah->prioritas_text }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            <div class="text-xs">
                                <div>Dibutuhkan: <span class="font-medium">{{ $daerah->relawan_dibutuhkan }}</span></div>
                                <div>Terdaftar: <span class="font-medium">{{ $daerah->relawan_terdaftar }}</span></div>
                                <div>Tersedia: <span class="font-medium text-blue-600">{{ $daerah->relawan_tersedia }}</span></div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @if($daerah->aktif)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                    <i class="fas fa-check-circle mr-1"></i> Aktif
                                </span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                    <i class="fas fa-ban mr-1"></i> Tidak Aktif
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-map-marked-alt text-4xl text-gray-300 mb-2 block"></i>
                            Belum ada data daerah
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t px-6 py-4 bg-gray-50">
            {{ $daerahList->links() }}
        </div>
    </div>
</div>
@endsection