@extends('layouts.admin')

@section('page-title', 'Balas Warga')
@section('page-description', 'Kirim tanggapan dan balasan kepada pelapor laporan')

@section('admin-content')
<div class="space-y-6">
    <!-- Response Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Belum Dibalas</p>
                    <p class="text-2xl font-bold text-red-600">{{ $belumDibalasCount }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-envelope text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sudah Dibalas</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $sudahDibalasCount }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-reply text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Tanggapan</p>
                    <p class="text-2xl font-bold text-green-600">{{ $totalTanggapan }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-comments text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan yang Perlu Dibalas -->
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Laporan yang Perlu Dibalas</h3>
            <p class="text-sm text-gray-600 mt-1">Laporan yang belum mendapat tanggapan dari admin</p>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($laporanBelumDibalas as $laporan)
            <div class="p-6 hover:bg-gray-50">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-sm font-medium text-gray-900">#{{ $laporan->id }}</span>
                            <span class="px-2 py-1 text-xs rounded-full
                                       {{ $laporan->status == 'pending' ? 'bg-orange-100 text-orange-800' :
                                          ($laporan->status == 'diproses' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                {{ ucfirst($laporan->status) }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $laporan->created_at->diffForHumans() }}</span>
                        </div>
                        <h4 class="font-medium text-gray-900 mb-1">{{ $laporan->judul_laporan }}</h4>
                        <p class="text-sm text-gray-600 mb-2">{{ Str::limit($laporan->deskripsi, 100) }}</p>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span><i class="fas fa-user mr-1"></i>{{ $laporan->nama_pelapor }}</span>
                            <span><i class="fas fa-tag mr-1"></i>{{ $laporan->kategori }}</span>
                            <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $laporan->lokasi }}</span>
                        </div>
                    </div>
                    <div class="flex gap-2 ml-4">
                        <button onclick="openReplyModal({{ $laporan->id }}, '{{ addslashes($laporan->judul_laporan) }}')"
                                class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-700">
                            <i class="fas fa-reply mr-1"></i>Balas
                        </button>
                        <a href="{{ route('admin.laporan.show', $laporan->id) }}"
                           class="bg-gray-100 text-gray-700 px-3 py-1 rounded-lg text-sm hover:bg-gray-200">
                            <i class="fas fa-eye mr-1"></i>Lihat
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-check-circle text-4xl mb-4 text-green-400"></i>
                <p>Semua laporan sudah mendapat tanggapan!</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Riwayat Tanggapan -->
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Tanggapan</h3>
            <p class="text-sm text-gray-600 mt-1">Tanggapan yang sudah dikirim kepada warga</p>
        </div>

        <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
            @forelse($tanggapanTerbaru as $tanggapan)
            <div class="p-6">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-gray-900">Laporan #{{ $tanggapan->laporan_id }}</span>
                        <span class="text-xs text-gray-500">{{ $tanggapan->created_at->diffForHumans() }}</span>
                    </div>
                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Terkirim</span>
                </div>
                <p class="text-sm text-gray-700 mb-2">{{ Str::limit($tanggapan->isi_tanggapan, 150) }}</p>
                <div class="text-xs text-gray-500">
                    Oleh: {{ $tanggapan->admin->name ?? 'Admin' }}
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-history text-4xl mb-4 text-gray-300"></i>
                <p>Belum ada riwayat tanggapan</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Reply Modal -->
<div id="replyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Balas Laporan</h3>
                    <button onclick="closeReplyModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <p id="modalTitle" class="text-sm text-gray-600 mt-1"></p>
            </div>

            <form id="replyForm" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="laporan_id" id="laporanId">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggapan</label>
                    <textarea name="isi_tanggapan" rows="6"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Tulis tanggapan Anda kepada pelapor..." required></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Laporan</label>
                    <select name="status_laporan" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="diproses">Tetap Diproses</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeReplyModal()"
                            class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Kirim Tanggapan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openReplyModal(laporanId, title) {
    document.getElementById('laporanId').value = laporanId;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('replyForm').action = `/admin/balas-warga/${laporanId}`;
    document.getElementById('replyModal').classList.remove('hidden');
}

function closeReplyModal() {
    document.getElementById('replyModal').classList.add('hidden');
    document.getElementById('replyForm').reset();
}

// Close modal when clicking outside
document.getElementById('replyModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReplyModal();
    }
});
</script>
@endsection