@extends('layouts.admin')

@section('page-title', 'Kelola Relawan')
@section('page-description', 'Kelola dan verifikasi pendaftar relawan')

@section('admin-content')
<div class="fade-in">
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Relawan</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalRelawan }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Menunggu Verifikasi</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $totalPending }}</p>
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Relawan Aktif</p>
                    <p class="text-2xl font-bold text-green-600">{{ $totalAktif }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Tidak Aktif</p>
                    <p class="text-2xl font-bold text-gray-600">{{ $totalNonaktif }}</p>
                </div>
                <div class="bg-gray-100 rounded-full p-3">
                    <i class="fas fa-ban text-gray-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Bencana Preview -->
    <div class="bg-slate-50 rounded-3xl shadow-lg p-6 mb-6 border border-slate-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Ringkasan Info Bencana</h3>
                <p class="text-gray-500 mt-2">Statistik relawan yang juga ditampilkan di halaman publik Info Bencana.</p>
            </div>
            <a href="{{ route('home') }}#informasi" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-full transition">
                <i class="fas fa-globe-americas"></i>
                Lihat Halaman Publik
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            @include('components.relawan-summary-card', [
                'title' => 'Total Relawan',
                'value' => $totalRelawan,
                'description' => 'Jumlah relawan terdaftar pada sistem.',
                'icon' => 'fas fa-users',
                'iconBgClass' => 'bg-blue-100',
                'iconTextClass' => 'text-blue-600',
                'valueTextClass' => 'text-blue-600',
                'footerText' => 'Data terintegrasi dengan modul admin kelola relawan.'
            ])
            @include('components.relawan-summary-card', [
                'title' => 'Relawan Aktif',
                'value' => $totalAktif,
                'description' => 'Relawan aktif yang siap bertugas.',
                'icon' => 'fas fa-hands-helping',
                'iconBgClass' => 'bg-green-100',
                'iconTextClass' => 'text-green-600',
                'valueTextClass' => 'text-green-600',
                'footerText' => 'Jumlah relawan aktif yang bisa dihubungi saat darurat.'
            ])
            @include('components.relawan-summary-card', [
                'title' => 'Menunggu Verifikasi',
                'value' => $totalPending,
                'description' => 'Relawan baru yang masih dalam proses verifikasi.',
                'icon' => 'fas fa-clock',
                'iconBgClass' => 'bg-yellow-100',
                'iconTextClass' => 'text-yellow-600',
                'valueTextClass' => 'text-yellow-600',
                'footerText' => 'Status ini berasal langsung dari data admin kelola relawan.'
            ])
        </div>

        <div>
            <h4 class="text-sm font-semibold text-slate-500 uppercase mb-3">Keahlian Relawan Aktif</h4>
            <div class="flex flex-wrap gap-3">
                @forelse($activeSkills as $skill)
                    <span class="px-4 py-2 rounded-full bg-blue-50 text-blue-600 border border-blue-100 text-sm">{{ $skill }}</span>
                @empty
                    <span class="px-4 py-2 rounded-full bg-gray-100 text-gray-600 text-sm">Tidak ada keahlian relawan aktif terdaftar.</span>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('admin.relawan.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Nama, email, no HP, domisili..."
                           class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 text-sm">
                    <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keahlian</label>
                <select name="keahlian" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 text-sm">
                    <option value="semua" {{ request('keahlian') == 'semua' ? 'selected' : '' }}>Semua Keahlian</option>
                    @foreach($keahlianList as $keahlian)
                        <option value="{{ $keahlian }}" {{ request('keahlian') == $keahlian ? 'selected' : '' }}>{{ $keahlian }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition text-sm">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>
                <a href="{{ route('admin.relawan.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition text-sm ml-2">
                    <i class="fas fa-undo-alt mr-1"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Bulk Action -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="border-b px-6 py-3 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-users mr-2 text-blue-500"></i>
                Daftar Relawan
            </h2>
            <div class="flex items-center gap-2">
                <select id="bulkStatus" class="border border-gray-300 rounded-lg px-3 py-1 text-sm">
                    <option value="">Pilih Aksi</option>
                    <option value="aktif">Setujui</option>
                    <option value="nonaktif">Nonaktifkan</option>
                </select>
                <button onclick="bulkUpdate()" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-lg text-sm">
                    <i class="fas fa-check-double mr-1"></i> Terapkan
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-10 px-4 py-3">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kontak</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Domisili</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Keahlian</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Daerah</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($relawans as $relawan)
                    <tr onclick="showDetail({{ $relawan->id }})" class="hover:bg-gray-50 transition cursor-pointer">
                        <td class="px-4 py-3">
                            <input type="checkbox" onclick="event.stopPropagation()" class="rowCheckbox rounded border-gray-300" value="{{ $relawan->id }}">
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">#{{ $relawan->id }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $relawan->nama_lengkap }}</p>
                                    <p class="text-xs text-gray-500">{{ $relawan->user->name ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            <div>{{ $relawan->no_hp }}</div>
                            <div class="text-xs text-gray-400">{{ $relawan->email }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $relawan->domisili }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full">
                                {{ $relawan->keahlian }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            @if($relawan->daerahButuhRelawan)
                                <div class="text-xs">
                                    <div class="font-medium text-gray-800">{{ $relawan->daerahButuhRelawan->nama_daerah }}</div>
                                    <div class="text-gray-500">{{ $relawan->daerahButuhRelawan->provinsi }}</div>
                                </div>
                            @else
                                <span class="text-gray-400 text-xs">Belum pilih</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($relawan->status == 'pending')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                    <i class="fas fa-clock mr-1"></i> Menunggu
                                </span>
                            @elseif($relawan->status == 'aktif')
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                    <i class="fas fa-check-circle mr-1"></i> Aktif
                                </span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                    <i class="fas fa-ban mr-1"></i> Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            {{ $relawan->created_at->format('d/m/Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-users text-4xl text-gray-300 mb-2 block"></i>
                            Belum ada data relawan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="border-t px-6 py-4 bg-gray-50">
            {{ $relawans->links() }}
        </div>
    </div>
</div>

<!-- Modal Detail Relawan -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Detail Relawan</h3>
            <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6" id="detailContent">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<!-- Modal Ubah Status -->
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-96 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Ubah Status Relawan</h3>
            <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="statusForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500">
                    <option value="pending">Menunggu Verifikasi</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Tidak Aktif</option>
                </select>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition">
                    Simpan
                </button>
                <button type="button" onclick="closeStatusModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 rounded-lg transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Select All Checkbox
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.rowCheckbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    }
    
    // Bulk Update
    function bulkUpdate() {
        const selectedIds = [];
        document.querySelectorAll('.rowCheckbox:checked').forEach(cb => {
            selectedIds.push(cb.value);
        });
        
        if (selectedIds.length === 0) {
            alert('Pilih minimal satu relawan');
            return;
        }
        
        const status = document.getElementById('bulkStatus').value;
        if (!status) {
            alert('Pilih status yang akan diterapkan');
            return;
        }
        
        if (confirm(`Yakin ingin mengubah ${selectedIds.length} relawan menjadi ${status === 'aktif' ? 'AKTIF' : 'NONAKTIF'}?`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.relawan.bulk") }}';
            form.innerHTML = `
                @csrf
                <input type="hidden" name="ids" value='${JSON.stringify(selectedIds)}'>
                <input type="hidden" name="status" value="${status}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    // Show Detail
    function showDetail(id) {
        const modal = document.getElementById('detailModal');
        const content = document.getElementById('detailContent');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        content.innerHTML = '<div class="text-center py-8"><i class="fas fa-spinner fa-spin text-2xl text-blue-600"></i><p class="mt-2">Loading...</p></div>';
        
        fetch(`/admin/relawan/${id}`)
            .then(response => response.text())
            .then(html => {
                content.innerHTML = html;
            })
            .catch(error => {
                content.innerHTML = '<div class="text-center py-8 text-red-600">Gagal memuat data</div>';
            });
    }
    
    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.getElementById('detailModal').classList.remove('flex');
    }
    
    // Change Status
    let currentRelawanId = null;
    
    function changeStatus(id, currentStatus) {
        currentRelawanId = id;
        const modal = document.getElementById('statusModal');
        const form = document.getElementById('statusForm');
        const select = form.querySelector('select');
        
        select.value = currentStatus;
        form.action = `/admin/relawan/${id}/status`;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeStatusModal() {
        const modal = document.getElementById('statusModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    // Close modal when clicking outside
    document.getElementById('detailModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeDetailModal();
    });
    
    document.getElementById('statusModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeStatusModal();
    });
</script>
@endsection