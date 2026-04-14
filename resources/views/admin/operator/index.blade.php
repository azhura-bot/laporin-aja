@extends('layouts.admin')

@section('page-title', 'Kelola Operator Lapangan')
@section('page-description', 'Tambah, edit, dan kelola operator lapangan')

@section('admin-content')
<div class="fade-in">
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Operator</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalOperators }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Operator Aktif</p>
                    <p class="text-3xl font-bold text-green-600">{{ $totalActive }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Operator Nonaktif</p>
                    <p class="text-3xl font-bold text-red-600">{{ $totalInactive }}</p>
                </div>
                <div class="bg-red-100 rounded-full p-3">
                    <i class="fas fa-ban text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Tambah & Filter -->
    <div class="bg-white rounded-xl shadow-md p-4 mb-6">
        <div class="flex flex-wrap justify-between items-center gap-4">
            <a href="{{ route('admin.operator.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Tambah Operator
            </a>
            
            <form method="GET" action="{{ route('admin.operator.index') }}" class="flex gap-2">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama, email, atau no HP..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 w-64">
                </div>
                <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                <a href="{{ route('admin.operator.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg transition">
                    <i class="fas fa-undo-alt"></i>
                </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Tabel Operator -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b">
                    <tr>
                        <th class="w-10 px-4 py-3">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No HP</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal Dibuat</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($operators as $operator)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <input type="checkbox" class="rowCheckbox rounded border-gray-300" value="{{ $operator->id }}">
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">#{{ $operator->id }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-hard-hat text-green-600 text-xs"></i>
                                </div>
                                <span class="font-medium text-gray-800">{{ $operator->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $operator->email }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $operator->no_hp ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($operator->status == 'aktif')
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                    <i class="fas fa-check-circle mr-1"></i> Aktif
                                </span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">
                                    <i class="fas fa-ban mr-1"></i> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $operator->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" onclick="openEditOperator({{ $operator->id }})"
                                        class="text-yellow-600 hover:text-yellow-800 transition"
                                        title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="changeStatus({{ $operator->id }}, '{{ $operator->status }}')" 
                                        class="text-blue-600 hover:text-blue-800 transition" title="Ubah Status">
                                    <i class="fas fa-toggle-on"></i>
                                </button>
                                <form action="{{ route('admin.operator.destroy', $operator->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus operator ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-users text-4xl text-gray-300 mb-2 block"></i>
                            Belum ada operator lapangan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="border-t px-6 py-4 bg-gray-50">
            {{ $operators->links() }}
        </div>
    </div>
</div>

<!-- Modal Ubah Status -->
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-96 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Ubah Status Operator</h3>
            <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="statusForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
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
    let currentOperatorId = null;
    
    function changeStatus(id, currentStatus) {
        currentOperatorId = id;
        const modal = document.getElementById('statusModal');
        const form = document.getElementById('statusForm');
        const select = form.querySelector('select');
        
        select.value = currentStatus;
        form.action = `/admin/operator/${id}/status`;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeStatusModal() {
        const modal = document.getElementById('statusModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function openEditOperator(id) {
        const editUrl = `/admin/operator/${id}/edit`;
        window.location.href = editUrl;
    }
    
    // Select All
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.rowCheckbox').forEach(cb => cb.checked = this.checked);
        });
    }
    
    // Close modal when clicking outside
    document.getElementById('statusModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeStatusModal();
    });
</script>
@endsection