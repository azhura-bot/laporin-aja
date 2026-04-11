@extends('layouts.admin')

@section('page-title', 'Kelola Status Laporan')
@section('page-description', 'Update status laporan dan pantau progress penanganan')

@section('admin-content')
<div class="fade-in">
    <!-- Status Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-blue-500 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Laporan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalLaporan ?? $laporan->total() }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-600 text-lg"></i>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-xs text-gray-400">Semua laporan</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border-l-4 border-orange-500 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Menunggu</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $pendingCount ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-lg"></i>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-xs text-orange-600">Perlu ditindaklanjuti</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border-l-4 border-blue-500 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Diproses</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $diprosesCount ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-spinner text-blue-600 text-lg"></i>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-xs text-blue-600">Sedang ditangani</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border-l-4 border-green-500 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Selesai</p>
                    <p class="text-2xl font-bold text-green-600">{{ $selesaiCount ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-lg"></i>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-xs text-green-600">Telah ditangani</span>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border p-4 mb-6">
        <div class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">Cari Laporan</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" id="searchInput" placeholder="Cari judul, pelapor, atau lokasi..." 
                           class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">Filter Status</label>
                <select id="statusFilter" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-400 text-sm">
                    <option value="all">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">Filter Kategori</label>
                <select id="kategoriFilter" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-400 text-sm">
                    <option value="all">Semua Kategori</option>
                    <option value="Infrastruktur">Infrastruktur</option>
                    <option value="Kebersihan">Kebersihan</option>
                    <option value="Kesehatan">Kesehatan</option>
                    <option value="Pendidikan">Pendidikan</option>
                    <option value="Keamanan">Keamanan</option>
                    <option value="Pelayanan Publik">Pelayanan Publik</option>
                    <option value="Lingkungan">Lingkungan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div>
                <button onclick="resetFilters()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition text-sm">
                    <i class="fas fa-undo-alt mr-1"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Laporan Table -->
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-list mr-2 text-blue-500"></i>
                        Daftar Laporan
                    </h3>
                    <p class="text-sm text-gray-500 mt-0.5">Kelola status semua laporan yang masuk</p>
                </div>
                <div class="text-sm text-gray-400">
                    Total: <span id="totalVisible">{{ $laporan->total() }}</span> laporan
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul Laporan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelapor</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="laporanTableBody">
                    @foreach($laporan as $item)
                    <tr onclick="window.location='{{ route('admin.laporan.show', $item->id) }}'" class="hover:bg-gray-50 transition laporan-row cursor-pointer" 
                        data-id="{{ $item->id }}"
                        data-status="{{ $item->status }}"
                        data-kategori="{{ $item->kategori }}"
                        data-judul="{{ strtolower($item->judul_laporan) }}"
                        data-pelapor="{{ strtolower($item->nama_pelapor) }}"
                        data-lokasi="{{ strtolower($item->lokasi) }}">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $item->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ Str::limit($item->judul_laporan, 45) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600 text-xs"></i>
                                </div>
                                <span class="text-sm text-gray-700">{{ $item->nama_pelapor }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">{{ $item->kategori }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-[200px] truncate">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-1 text-xs"></i>
                            {{ Str::limit($item->lokasi, 30) }}
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.kelola-status.update', $item->id) }}" class="inline status-form">
                                @csrf
                                @method('PUT')
                                <select name="status" onclick="event.stopPropagation()" onchange="confirmStatusChange(this)"
                                        class="text-xs px-3 py-1.5 rounded-full border-0 font-medium cursor-pointer transition-all
                                        {{ $item->status == 'pending' ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 
                                           ($item->status == 'diproses' ? 'bg-blue-100 text-blue-700 hover:bg-blue-200' : 
                                           'bg-green-100 text-green-700 hover:bg-green-200') }}">
                                    <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>📋 Menunggu</option>
                                    <option value="diproses" {{ $item->status == 'diproses' ? 'selected' : '' }}>⚙️ Diproses</option>
                                    <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <i class="far fa-calendar-alt text-gray-400 mr-1"></i>
                            {{ $item->created_at->format('d/m/Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($laporan->hasPages())
        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $laporan->links() }}
        </div>
        @endif
    </div>

    <!-- Bulk Actions Card -->
    <div class="bg-white rounded-xl shadow-sm border mt-6 overflow-hidden">
        <div class="px-6 py-4 border-b bg-gradient-to-r from-gray-50 to-white">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-layer-group mr-2 text-purple-500"></i>
                Aksi Massal
            </h3>
            <p class="text-sm text-gray-500 mt-0.5">Update beberapa laporan sekaligus</p>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.kelola-status.bulk') }}" class="flex flex-wrap gap-4 items-end">
                @csrf
                <div class="flex-1 min-w-[250px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Laporan</label>
                    <div class="relative">
                        <select name="laporan_ids[]" multiple class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-blue-400" size="4">
                            @foreach($laporan as $item)
                            <option value="{{ $item->id }}">#{{ $item->id }} - {{ Str::limit($item->judul_laporan, 40) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">
                        <i class="fas fa-info-circle mr-1"></i> Tekan <kbd class="px-1 bg-gray-100 rounded">Ctrl</kbd> untuk memilih multiple
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                    <select name="status" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-blue-400">
                        <option value="pending">📋 Menunggu</option>
                        <option value="diproses">⚙️ Diproses</option>
                        <option value="selesai">✅ Selesai</option>
                    </select>
                </div>
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-5 py-2 rounded-lg transition shadow-sm">
                    <i class="fas fa-check-double mr-2"></i> Update Massal
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Quick Update -->
<div id="quickUpdateModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full animate-fadeInUp">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-bolt text-purple-500 mr-2"></i>
                Update Cepat Status
            </h3>
            <button onclick="closeQuickUpdateModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <p class="text-gray-600 mb-4" id="quickUpdateTitle"></p>
            <form id="quickUpdateForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Status</label>
                    <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:border-blue-400">
                        <option value="pending">📋 Menunggu</option>
                        <option value="diproses">⚙️ Diproses</option>
                        <option value="selesai">✅ Selesai</option>
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg transition">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <button type="button" onclick="closeQuickUpdateModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fadeInUp {
        animation: fadeInUp 0.3s ease-out;
    }
    kbd {
        font-family: monospace;
        font-size: 11px;
        padding: 2px 5px;
    }
    select[name="laporan_ids[]"] {
        min-height: 120px;
    }
</style>

<script>
    // Filter functionality
    function filterTable() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const kategoriFilter = document.getElementById('kategoriFilter').value;
        
        const rows = document.querySelectorAll('.laporan-row');
        let visibleCount = 0;
        
        rows.forEach(row => {
            const status = row.dataset.status;
            const kategori = row.dataset.kategori;
            const judul = row.dataset.judul;
            const pelapor = row.dataset.pelapor;
            const lokasi = row.dataset.lokasi;
            
            let show = true;
            
            if (statusFilter !== 'all' && status !== statusFilter) show = false;
            if (kategoriFilter !== 'all' && kategori !== kategoriFilter) show = false;
            if (searchTerm && !judul.includes(searchTerm) && !pelapor.includes(searchTerm) && !lokasi.includes(searchTerm)) show = false;
            
            row.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });
        
        document.getElementById('totalVisible').textContent = visibleCount;
    }
    
    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('statusFilter').value = 'all';
        document.getElementById('kategoriFilter').value = 'all';
        filterTable();
    }
    
    document.getElementById('searchInput').addEventListener('keyup', filterTable);
    document.getElementById('statusFilter').addEventListener('change', filterTable);
    document.getElementById('kategoriFilter').addEventListener('change', filterTable);
    
    // Confirm status change
    function confirmStatusChange(selectElement) {
        const form = selectElement.closest('.status-form');
        const oldStatus = selectElement.querySelector('option[selected]')?.value || selectElement.value;
        const newStatus = selectElement.value;
        
        const statusText = {
            'pending': 'Menunggu',
            'diproses': 'Diproses',
            'selesai': 'Selesai'
        };
        
        if (confirm(`Apakah Anda yakin ingin mengubah status menjadi ${statusText[newStatus]}?`)) {
            form.submit();
        } else {
            selectElement.value = oldStatus;
            // Update styling
            updateSelectStyling(selectElement);
        }
    }
    
    function updateSelectStyling(select) {
        select.classList.remove('bg-yellow-100', 'text-yellow-700', 'hover:bg-yellow-200',
                                'bg-blue-100', 'text-blue-700', 'hover:bg-blue-200',
                                'bg-green-100', 'text-green-700', 'hover:bg-green-200');
        
        if (select.value === 'pending') {
            select.classList.add('bg-yellow-100', 'text-yellow-700', 'hover:bg-yellow-200');
        } else if (select.value === 'diproses') {
            select.classList.add('bg-blue-100', 'text-blue-700', 'hover:bg-blue-200');
        } else if (select.value === 'selesai') {
            select.classList.add('bg-green-100', 'text-green-700', 'hover:bg-green-200');
        }
    }
    
    // Quick update modal
    let quickUpdateId = null;
    
    function quickUpdateStatus(id, currentStatus) {
        quickUpdateId = id;
        const modal = document.getElementById('quickUpdateModal');
        const form = document.getElementById('quickUpdateForm');
        const title = document.getElementById('quickUpdateTitle');
        
        title.innerHTML = `<i class="fas fa-file-alt mr-1"></i> Update status untuk laporan #${id}`;
        form.action = `/admin/kelola-status/${id}`;
        form.querySelector('select[name="status"]').value = currentStatus;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeQuickUpdateModal() {
        const modal = document.getElementById('quickUpdateModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    // Close modal when clicking outside
    document.getElementById('quickUpdateModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeQuickUpdateModal();
    });
    
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        filterTable();
    });
</script>
@endsection