@extends('layouts.admin')

@section('page-title', 'Detail Daerah Butuh Relawan')
@section('page-description', 'Informasi lengkap daerah yang membutuhkan bantuan relawan')

@section('admin-content')
<div class="fade-in max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.daerah-butuh-relawan.index') }}" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $daerah->nama_daerah }}</h1>
                    <p class="text-gray-500 text-sm">{{ $daerah->provinsi }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.daerah-butuh-relawan.edit', $daerah) }}"
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <form action="{{ route('admin.daerah-butuh-relawan.destroy', $daerah) }}" method="POST" class="inline"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus daerah ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informasi Utama -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Detail Daerah -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Daerah</h2>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Daerah</label>
                            <p class="text-gray-800">{{ $daerah->nama_daerah }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Provinsi</label>
                            <p class="text-gray-800">{{ $daerah->provinsi }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Prioritas</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $daerah->prioritas_badge_class }}">
                                {{ $daerah->prioritas_badge }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Status</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $daerah->aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $daerah->aktif ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>

                    @if($daerah->deskripsi)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Deskripsi</label>
                        <p class="text-gray-800 bg-gray-50 rounded-lg p-3">{{ $daerah->deskripsi }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Statistik Relawan -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistik Relawan</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $daerah->relawan_dibutuhkan }}</div>
                        <div class="text-sm text-gray-600">Dibutuhkan</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $daerah->relawan_terdaftar }}</div>
                        <div class="text-sm text-gray-600">Terdaftar</div>
                    </div>
                    <div class="text-center p-4 {{ $daerah->relawan_tersedia > 0 ? 'bg-yellow-50' : 'bg-gray-50' }} rounded-lg">
                        <div class="text-2xl font-bold {{ $daerah->relawan_tersedia > 0 ? 'text-yellow-600' : 'text-gray-600' }}">{{ $daerah->relawan_tersedia }}</div>
                        <div class="text-sm text-gray-600">Tersedia</div>
                    </div>
                </div>
            </div>

            <!-- Daftar Relawan -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Relawan Terdaftar</h2>
                @if($daerah->relawans->count() > 0)
                    <div class="space-y-3">
                        @foreach($daerah->relawans as $relawan)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $relawan->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $relawan->user->email }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">{{ $relawan->created_at->format('d M Y') }}</div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-users text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">Belum ada relawan yang terdaftar di daerah ini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.daerah-butuh-relawan.edit', $daerah) }}"
                       class="w-full flex items-center gap-3 px-4 py-3 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition">
                        <i class="fas fa-edit"></i>
                        Edit Daerah
                    </a>
                    <a href="{{ route('admin.daerah-butuh-relawan.create') }}"
                       class="w-full flex items-center gap-3 px-4 py-3 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg transition">
                        <i class="fas fa-plus"></i>
                        Tambah Daerah Baru
                    </a>
                    <a href="{{ route('admin.daerah-butuh-relawan.index') }}"
                       class="w-full flex items-center gap-3 px-4 py-3 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg transition">
                        <i class="fas fa-list"></i>
                        Lihat Semua Daerah
                    </a>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Timeline</h3>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                        <div>
                            <div class="text-sm font-medium text-gray-800">Dibuat</div>
                            <div class="text-xs text-gray-500">{{ $daerah->created_at->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                    @if($daerah->updated_at != $daerah->created_at)
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                        <div>
                            <div class="text-sm font-medium text-gray-800">Terakhir Diupdate</div>
                            <div class="text-xs text-gray-500">{{ $daerah->updated_at->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection