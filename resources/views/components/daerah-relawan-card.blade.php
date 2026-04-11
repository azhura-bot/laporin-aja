@props([
    'daerah',
    'showCta' => true
])

<div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 hover:shadow-xl transition-all duration-300">
    <div class="flex items-start justify-between mb-4">
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-2">
                <h3 class="text-lg font-semibold text-gray-800">{{ $daerah->nama_daerah }}</h3>
                <span class="px-2 py-1 {{ $daerah->prioritas_badge }} text-xs rounded-full font-medium">
                    {{ $daerah->prioritas_text }}
                </span>
            </div>
            <p class="text-sm text-gray-600 mb-2">{{ $daerah->provinsi }}</p>
            @if($daerah->deskripsi)
                <p class="text-sm text-gray-700 mb-3">{{ Str::limit($daerah->deskripsi, 100) }}</p>
            @endif
        </div>
        <div class="ml-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-map-marker-alt text-blue-600 text-lg"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="text-center">
            <div class="text-lg font-bold text-orange-600">{{ $daerah->relawan_dibutuhkan }}</div>
            <div class="text-xs text-gray-500">Dibutuhkan</div>
        </div>
        <div class="text-center">
            <div class="text-lg font-bold text-green-600">{{ $daerah->relawan_terdaftar }}</div>
            <div class="text-xs text-gray-500">Terdaftar</div>
        </div>
    </div>

    @if($daerah->relawan_tersedia > 0)
        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4">
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle text-green-600"></i>
                <span class="text-sm text-green-700 font-medium">
                    Masih butuh {{ $daerah->relawan_tersedia }} relawan lagi
                </span>
            </div>
        </div>
    @else
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mb-4">
            <div class="flex items-center gap-2">
                <i class="fas fa-users text-gray-600"></i>
                <span class="text-sm text-gray-700">
                    Kuota relawan sudah terpenuhi
                </span>
            </div>
        </div>
    @endif

    @if($showCta)
        @if($daerah->relawan_tersedia > 0)
            <a href="@auth{{ route('dashboard') }}@else{{ route('register') }}@endauth"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition text-sm w-full justify-center">
                <i class="fas fa-hands-helping"></i>
                Gabung Relawan
            </a>
        @else
            <button disabled
               class="inline-flex items-center gap-2 bg-gray-400 text-white px-4 py-2 rounded-lg font-medium text-sm w-full justify-center cursor-not-allowed">
                <i class="fas fa-check-circle"></i>
                Kuota Penuh
            </button>
        @endif
    @endif
</div>