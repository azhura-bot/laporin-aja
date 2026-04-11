@extends('layouts.admin')

@section('page-title', 'Semua Laporan')
@section('page-description', 'Kelola dan pantau seluruh laporan masyarakat')

@section('admin-content')
<div class="fade-in space-y-6 max-w-[1600px] mx-auto">
    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="grid gap-4 lg:grid-cols-[1.8fr_auto_auto_auto_auto] items-end">
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Lampiran</label>
                <select id="lampiranFilter" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                    <option value="semua">Semua</option>
                    <option value="ada">Ada Lampiran</option>
                    <option value="tidak">Tidak Ada Lampiran</option>
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
            @if($laporan->count())
                <table class="min-w-full table-auto">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-16">ID</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-20">Gambar</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul Laporan</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pelapor</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lokasi</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200" id="laporanTableBody">
                        @foreach($laporan as $item)
                        <tr onclick="window.location='{{ route('admin.laporan.show', $item->id) }}'" class="hover:bg-gray-50 transition duration-200 laporan-row cursor-pointer" 
                            data-status="{{ $item->status }}"
                            data-kategori="{{ $item->kategori }}"
                            data-judul="{{ strtolower($item->judul_laporan) }}"
                            data-lokasi="{{ strtolower($item->lokasi) }}"
                            data-pelapor="{{ strtolower($item->nama_pelapor) }}"
                            data-lampiran="{{ $item->lampiran ? 'ada' : 'tidak' }}">
                            
                            <td class="px-4 py-4 text-sm font-medium text-gray-900">#{{ $item->id }}</td>
                            
                            <!-- Kolom Gambar - DIPERBAIKI -->
                            <td class="px-4 py-4">
                                @php
                                    $imageUrl = null;
                                    $isImage = false;
                                    $fileExists = false;
                                    
                                    if($item->lampiran) {
                                        // Coba berbagai kemungkinan path
                                        $possiblePaths = [
                                            'storage/' . $item->lampiran,
                                            'storage/lampiran/' . $item->lampiran,
                                            $item->lampiran
                                        ];
                                        
                                        foreach($possiblePaths as $path) {
                                            if(file_exists(public_path($path))) {
                                                $imageUrl = asset($path);
                                                $fileExists = true;
                                                break;
                                            }
                                        }
                                        
                                        // Jika tidak ditemukan, coba langsung dari asset
                                        if(!$fileExists) {
                                            $imageUrl = asset('storage/' . $item->lampiran);
                                        }
                                        
                                        // Cek apakah file adalah gambar
                                        $ext = strtolower(pathinfo($item->lampiran, PATHINFO_EXTENSION));
                                        $imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
                                        $isImage = in_array($ext, $imageExts);
                                    }
                                @endphp
                                
                                @if($item->lampiran && $fileExists && $isImage)
                                    <button onclick="event.stopPropagation(); showImageModal('{{ $imageUrl }}', '{{ addslashes($item->judul_laporan) }}')" 
                                            class="group relative block">
                                        <img src="{{ $imageUrl }}" 
                                             alt="Lampiran" 
                                             class="w-12 h-12 rounded-lg object-cover border-2 border-gray-200 group-hover:border-blue-500 transition cursor-pointer"
                                             onerror="this.src='https://placehold.co/400x400?text=Error+Load'; this.onerror=null;">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded-lg transition flex items-center justify-center">
                                            <i class="fas fa-search-plus text-white text-xs opacity-0 group-hover:opacity-100 transition"></i>
                                        </div>
                                    </button>
                                @elseif($item->lampiran && $fileExists && !$isImage)
                                    <a href="{{ $imageUrl }}" target="_blank" onclick="event.stopPropagation()" 
                                       class="flex flex-col items-center gap-1 text-blue-600 hover:text-blue-800">
                                        @php
                                            $ext = strtolower(pathinfo($item->lampiran, PATHINFO_EXTENSION));
                                            $icon = 'fa-file';
                                            if($ext == 'pdf') $icon = 'fa-file-pdf';
                                            elseif(in_array($ext, ['doc', 'docx'])) $icon = 'fa-file-word';
                                            elseif(in_array($ext, ['xls', 'xlsx'])) $icon = 'fa-file-excel';
                                            elseif(in_array($ext, ['mp4', 'avi', 'mov'])) $icon = 'fa-file-video';
                                        @endphp
                                        <i class="fas {{ $icon }} text-red-500 text-2xl"></i>
                                        <span class="text-xs">Lihat</span>
                                    </a>
                                @elseif($item->lampiran && !$fileExists)
                                    <div class="w-12 h-12 rounded-lg bg-red-50 flex flex-col items-center justify-center">
                                        <i class="fas fa-exclamation-triangle text-red-400 text-lg"></i>
                                        <span class="text-xs text-red-400 mt-1">File Hilang</span>
                                    </div>
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex flex-col items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-lg"></i>
                                        <span class="text-xs text-gray-400 mt-1">No Image</span>
                                    </div>
                                @endif
                            </td>
                            
                            <td class="px-4 py-4">
                                <div class="max-w-xs">
                                    <p class="text-sm font-medium text-gray-800">{{ Str::limit($item->judul_laporan, 50) }}</p>
                                    <p class="text-xs text-gray-400 mt-1">ID: #{{ $item->id }}</p>
                                </div>
                            </td>
                            
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-user text-blue-600 text-xs"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate max-w-[150px]">{{ $item->nama_pelapor }}</p>
                                        <p class="text-xs text-gray-500 truncate max-w-[150px]">{{ $item->email }}</p>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full whitespace-nowrap">
                                    {{ $item->kategori }}
                                </span>
                            </td>
                            
                            <td class="px-4 py-4 text-sm text-gray-600">
                                <div class="flex items-center gap-1 min-w-[150px]">
                                    <i class="fas fa-map-marker-alt text-gray-400 text-xs flex-shrink-0"></i>
                                    <span class="truncate">{{ Str::limit($item->lokasi, 35) }}</span>
                                </div>
                            </td>
                            
                            <td class="px-4 py-4">
                                @if($item->status == 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full whitespace-nowrap">
                                        <i class="fas fa-clock mr-1"></i> Menunggu
                                    </span>
                                @elseif($item->status == 'diproses')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full whitespace-nowrap">
                                        <i class="fas fa-spinner mr-1"></i> Diproses
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full whitespace-nowrap">
                                        <i class="fas fa-check mr-1"></i> Selesai
                                    </span>
                                @endif
                            </td>
                            
                            <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ $item->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-6 text-center text-gray-500">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2 block"></i>
                    Tidak ada laporan untuk ditampilkan.
                </div>
            @endif
        </div>

        <!-- Pagination -->
        <div class="border-t px-6 py-4 bg-gray-50">
            {{ $laporan->links() }}
        </div>
    </div>
</div>

<!-- Modal Preview Gambar -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 z-50 hidden items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-4xl max-h-[90vh] bg-white rounded-xl overflow-hidden" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center px-4 py-3 bg-gray-100 border-b">
            <h3 class="font-semibold text-gray-800 truncate" id="modalTitle">Preview Gambar</h3>
            <button onclick="closeImageModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-4 flex justify-center items-center bg-gray-900 min-h-[300px]">
            <img id="modalImage" src="" alt="Preview" class="max-w-full max-h-[70vh] object-contain">
        </div>
        <div class="px-4 py-3 bg-gray-100 border-t flex justify-end gap-2">
            <a id="downloadLink" href="#" download class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition text-sm">
                <i class="fas fa-download mr-2"></i>Download
            </a>
            <button onclick="closeImageModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg transition text-sm">
                <i class="fas fa-times mr-2"></i>Tutup
            </button>
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
                    <option value="pending">📋 Menunggu</option>
                    <option value="diproses">⚙️ Diproses</option>
                    <option value="selesai">✅ Selesai</option>
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
    // Image Modal functions
    function showImageModal(imageUrl, title) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        const downloadLink = document.getElementById('downloadLink');
        
        modalImage.src = imageUrl;
        modalTitle.textContent = title || 'Preview Gambar';
        downloadLink.href = imageUrl;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }
    
    // Filter functions
    function filterTable() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const kategoriFilter = document.getElementById('kategoriFilter').value;
        const lampiranFilter = document.getElementById('lampiranFilter').value;
        
        const rows = document.querySelectorAll('.laporan-row');
        
        rows.forEach(row => {
            const status = row.dataset.status;
            const kategori = row.dataset.kategori;
            const judul = row.dataset.judul;
            const lokasi = row.dataset.lokasi;
            const pelapor = row.dataset.pelapor;
            const lampiran = row.dataset.lampiran;
            
            let show = true;
            
            if (statusFilter !== 'semua' && status !== statusFilter) show = false;
            if (kategoriFilter !== 'semua' && kategori !== kategoriFilter) show = false;
            if (lampiranFilter !== 'semua' && lampiran !== lampiranFilter) show = false;
            if (searchTerm && !judul.includes(searchTerm) && !lokasi.includes(searchTerm) && !pelapor.includes(searchTerm)) show = false;
            
            row.style.display = show ? '' : 'none';
        });
    }
    
    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('statusFilter').value = 'semua';
        document.getElementById('kategoriFilter').value = 'semua';
        document.getElementById('lampiranFilter').value = 'semua';
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
    document.getElementById('lampiranFilter').addEventListener('change', filterTable);
    
    // Close modal when clicking outside
    document.getElementById('statusModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
    
    // Escape key to close modals
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
            closeModal();
        }
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    
    #imageModal .bg-white {
        animation: fadeIn 0.2s ease-out;
    }
    
    .group:hover .group-hover\:bg-opacity-30 {
        --tw-bg-opacity: 0.3;
    }
    
    @media (max-width: 768px) {
        .table-auto {
            min-width: 1000px;
        }
    }
</style>
@endsection