@extends('layouts.admin')

@section('page-title', 'Semua Laporan')
@section('page-description', 'Kelola dan pantau seluruh laporan masyarakat')

@section('admin-content')
<div class="fade-in">
    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <div class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Laporan</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Cari judul, lokasi, atau pelapor..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="statusFilter" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                    <option value="semua">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select id="kategoriFilter" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                    <option value="semua">Semua Kategori</option>
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
                <button onclick="resetFilters()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-undo-alt mr-2"></i>Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Laporan Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul Laporan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pelapor</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="laporanTableBody">
                    @foreach($laporan as $item)
                    <tr class="hover:bg-gray-50 transition duration-200 laporan-row" 
                        data-status="{{ $item->status }}"
                        data-kategori="{{ $item->kategori }}"
                        data-judul="{{ strtolower($item->judul_laporan) }}"
                        data-lokasi="{{ strtolower($item->lokasi) }}"
                        data-pelapor="{{ strtolower($item->nama_pelapor) }}">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $item->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ Str::limit($item->judul_laporan, 50) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $item->nama_pelapor }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                            {{ Str::limit($item->lokasi, 30) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($item->status == 'pending')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                    <i class="fas fa-clock mr-1"></i> Menunggu
                                </span>
                            @elseif($item->status == 'diproses')
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                    <i class="fas fa-spinner mr-1"></i> Diproses
                                </span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                    <i class="fas fa-check mr-1"></i> Selesai
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <i class="far fa-calendar-alt mr-1"></i>
                            {{ $item->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.laporan.show', $item->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 transition" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button onclick="changeStatus({{ $item->id }}, '{{ $item->status }}')" 
                                        class="text-green-600 hover:text-green-800 transition" title="Ubah Status">
                                    <i class="fas fa-tasks"></i>
                                </button>
                                <form action="{{ route('admin.laporan.destroy', $item->id) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="border-t px-6 py-4 bg-gray-50">
            {{ $laporan->links() }}
        </div>
    </div>
</div>

<!-- Modal Ubah Status -->
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-96 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Ubah Status Laporan</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="statusForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                    <option value="pending">Menunggu</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition">
                    Simpan
                </button>
                <button type="button" onclick="closeModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 rounded-lg transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Filter functions
    function filterTable() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const kategoriFilter = document.getElementById('kategoriFilter').value;
        
        const rows = document.querySelectorAll('.laporan-row');
        
        rows.forEach(row => {
            const status = row.dataset.status;
            const kategori = row.dataset.kategori;
            const judul = row.dataset.judul;
            const lokasi = row.dataset.lokasi;
            const pelapor = row.dataset.pelapor;
            
            let show = true;
            
            if (statusFilter !== 'semua' && status !== statusFilter) show = false;
            if (kategoriFilter !== 'semua' && kategori !== kategoriFilter) show = false;
            if (searchTerm && !judul.includes(searchTerm) && !lokasi.includes(searchTerm) && !pelapor.includes(searchTerm)) show = false;
            
            row.style.display = show ? '' : 'none';
        });
    }
    
    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('statusFilter').value = 'semua';
        document.getElementById('kategoriFilter').value = 'semua';
        filterTable();
    }
    
    // Status change modal
    let currentLaporanId = null;
    
    function changeStatus(id, currentStatus) {
        currentLaporanId = id;
        const modal = document.getElementById('statusModal');
        const form = document.getElementById('statusForm');
        const select = form.querySelector('select');
        
        select.value = currentStatus;
        form.action = `/admin/laporan/${id}/status`;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeModal() {
        const modal = document.getElementById('statusModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    // Event listeners
    document.getElementById('searchInput').addEventListener('keyup', filterTable);
    document.getElementById('statusFilter').addEventListener('change', filterTable);
    document.getElementById('kategoriFilter').addEventListener('change', filterTable);
    
    // Close modal when clicking outside
    document.getElementById('statusModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endsection