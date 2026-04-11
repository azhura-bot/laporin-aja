<div class="space-y-4">
    <!-- Informasi Pribadi -->
    <div>
        <h4 class="text-md font-semibold text-gray-800 border-b pb-2 mb-3">Informasi Pribadi</h4>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <p class="text-xs text-gray-500">Nama Lengkap</p>
                <p class="font-medium text-gray-800">{{ $relawan->nama_lengkap }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Email</p>
                <p class="font-medium text-gray-800">{{ $relawan->email }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Nomor Telepon</p>
                <p class="font-medium text-gray-800">{{ $relawan->no_hp }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Domisili</p>
                <p class="font-medium text-gray-800">{{ $relawan->domisili }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Keahlian</p>
                <p class="font-medium text-gray-800">
                    <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full">{{ $relawan->keahlian }}</span>
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Daerah yang Dipilih</p>
                <p class="font-medium text-gray-800">
                    @if($relawan->daerahButuhRelawan)
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">
                            {{ $relawan->daerahButuhRelawan->nama_daerah }}, {{ $relawan->daerahButuhRelawan->provinsi }}
                        </span>
                    @else
                        <span class="text-gray-500 text-sm">Belum memilih daerah</span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Status</p>
                <p>{!! $relawan->status_badge !!}</p>
            </div>
        </div>
    </div>
    
    <!-- Motivasi -->
    @if($relawan->motivasi)
    <div>
        <h4 class="text-md font-semibold text-gray-800 border-b pb-2 mb-3">Motivasi Bergabung</h4>
        <div class="bg-gray-50 rounded-lg p-3">
            <p class="text-gray-700 text-sm italic">"{{ $relawan->motivasi }}"</p>
        </div>
    </div>
    @endif
    
    <!-- Informasi Akun -->
    <div>
        <h4 class="text-md font-semibold text-gray-800 border-b pb-2 mb-3">Informasi Akun</h4>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <p class="text-xs text-gray-500">Username</p>
                <p class="font-medium text-gray-800">{{ $relawan->user->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Tanggal Daftar</p>
                <p class="font-medium text-gray-800">{{ $relawan->created_at->format('d F Y H:i') }}</p>
            </div>
        </div>
    </div>
    
    <!-- Tombol Aksi -->
    <div class="flex gap-2 pt-3 border-t">
        <button onclick="changeStatus({{ $relawan->id }}, '{{ $relawan->status }}')" 
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition text-sm">
            <i class="fas fa-tasks mr-1"></i> Ubah Status
        </button>
        <form action="{{ route('admin.relawan.destroy', $relawan->id) }}" method="POST" class="flex-1"
              onsubmit="return confirm('Yakin ingin menghapus relawan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg transition text-sm">
                <i class="fas fa-trash mr-1"></i> Hapus
            </button>
        </form>
    </div>
</div>