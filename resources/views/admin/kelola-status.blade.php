@extends('layouts.admin')

@section('page-title', 'Kelola Status Laporan')
@section('page-description', 'Update status laporan dan pantau progress penanganan')

@section('admin-content')
<div class="space-y-6">
    <!-- Status Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Menunggu</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $pendingCount }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sedang Diproses</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $diprosesCount }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-cog text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Selesai</p>
                    <p class="text-2xl font-bold text-green-600">{{ $selesaiCount }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan Table -->
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Laporan</h3>
            <p class="text-sm text-gray-600 mt-1">Kelola status semua laporan yang masuk</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelapor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($laporan as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">#{{ $item->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($item->judul_laporan, 40) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->nama_pelapor }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->kategori }}</td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.kelola-status.update', $item->id) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()"
                                        data-original="{{ $item->status }}"
                                        class="text-xs px-2 py-1 rounded-full border-0 font-medium
                                               {{ $item->status == 'pending' ? 'bg-orange-100 text-orange-800' :
                                                  ($item->status == 'diproses' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="diproses" {{ $item->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.laporan.show', $item->id) }}"
                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.laporan.edit', $item->id) }}"
                                   class="text-green-600 hover:text-green-800 text-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
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

    <!-- Bulk Actions -->
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Massal</h3>
        <form method="POST" action="{{ route('admin.kelola-status.bulk') }}" class="flex gap-4 items-end">
            @csrf
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Laporan</label>
                <select name="laporan_ids[]" multiple class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" size="3">
                    @foreach($laporan as $item)
                    <option value="{{ $item->id }}">#{{ $item->id }} - {{ Str::limit($item->judul_laporan, 30) }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Tekan Ctrl untuk memilih multiple</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="pending">Menunggu</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                Update Massal
            </button>
        </form>
    </div>
</div>

<script>
// Auto-submit status changes with confirmation
document.querySelectorAll('select[name="status"]').forEach(select => {
    // Store original value on page load
    select.setAttribute('data-original', select.value);

    select.addEventListener('change', function() {
        const originalValue = this.getAttribute('data-original');
        const newValue = this.value;

        if (confirm('Apakah Anda yakin ingin mengubah status laporan ini?')) {
            // If confirmed, submit the form
            this.form.submit();
        } else {
            // If cancelled, reset to original value
            this.value = originalValue;
            // Also reset the styling
            updateSelectStyling(this);
        }
    });
});

// Function to update select styling based on value
function updateSelectStyling(select) {
    // Remove existing classes
    select.classList.remove('bg-orange-100', 'text-orange-800', 'bg-blue-100', 'text-blue-800', 'bg-green-100', 'text-green-800');

    // Add appropriate classes based on value
    if (select.value === 'pending') {
        select.classList.add('bg-orange-100', 'text-orange-800');
    } else if (select.value === 'diproses') {
        select.classList.add('bg-blue-100', 'text-blue-800');
    } else if (select.value === 'selesai') {
        select.classList.add('bg-green-100', 'text-green-800');
    }
}
</script>
@endsection