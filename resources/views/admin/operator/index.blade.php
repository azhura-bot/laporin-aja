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
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($operators as $operator)
                    <tr class="hover:bg-gray-50 transition cursor-pointer operator-row" 
                        onclick="window.location.href='{{ route('admin.operator.edit', $operator->id) }}'">
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
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

<script>
    // Select All
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.rowCheckbox').forEach(cb => cb.checked = this.checked);
        });
    }
    
    // Prevent row click when clicking checkbox
    document.querySelectorAll('.rowCheckbox').forEach(checkbox => {
        checkbox.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
</script>
@endsection