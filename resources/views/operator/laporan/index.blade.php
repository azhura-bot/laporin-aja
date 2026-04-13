@extends('layouts.operator')

@section('page-title', $pageTitle)
@section('page-description', $pageDescription)

@section('operator-content')
<div class="fade-in space-y-6">
    <form method="GET" class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="grid gap-4 xl:grid-cols-[1.7fr_auto_auto_auto]">
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Cari laporan</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, pelapor, lokasi, kategori..."
                           class="w-full rounded-2xl border border-slate-200 py-3 pl-11 pr-4 text-sm outline-none transition focus:border-blue-400">
                </div>
            </div>

            @if($historyMode)
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Kategori</label>
                    <select name="kategori" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-400">
                        <option value="semua" @selected(request('kategori') === 'semua' || !request()->has('kategori'))>Semua Kategori</option>
                        <option value="Infrastruktur" @selected(request('kategori') === 'Infrastruktur')>Infrastruktur</option>
                        <option value="Kebersihan" @selected(request('kategori') === 'Kebersihan')>Kebersihan</option>
                        <option value="Kesehatan" @selected(request('kategori') === 'Kesehatan')>Kesehatan</option>
                        <option value="Pendidikan" @selected(request('kategori') === 'Pendidikan')>Pendidikan</option>
                        <option value="Keamanan" @selected(request('kategori') === 'Keamanan')>Keamanan</option>
                        <option value="Pelayanan Publik" @selected(request('kategori') === 'Pelayanan Publik')>Pelayanan Publik</option>
                        <option value="Lingkungan" @selected(request('kategori') === 'Lingkungan')>Lingkungan</option>
                        <option value="Lainnya" @selected(request('kategori') === 'Lainnya')>Lainnya</option>
                    </select>
                </div>
            @else
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Status</label>
                    <select name="status" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-400">
                        <option value="semua" @selected(request('status') === 'semua' || !request()->has('status'))>Semua Status Aktif</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                        <option value="diproses" @selected(request('status') === 'diproses')>Diproses</option>
                    </select>
                </div>
            @endif

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Urutkan</label>
                <select name="sort" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-400">
                    <option value="terbaru" @selected(request('sort', 'terbaru') === 'terbaru')>Terbaru</option>
                    <option value="terlama" @selected(request('sort') === 'terlama')>Terlama</option>
                    <option value="status" @selected(request('sort') === 'status')>Status</option>
                </select>
            </div>

            <div class="flex items-end gap-3">
                <button type="submit" class="w-full rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                    Terapkan
                </button>
            </div>
        </div>
    </form>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            @if($laporan->count())
                <table class="min-w-full">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Laporan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Lokasi</th>
                            @unless($historyMode)
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                            @endunless
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tugas</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($laporan as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="flex h-14 w-14 items-center justify-center overflow-hidden rounded-2xl bg-slate-100">
                                            @if($item->lampiran && $item->is_lampiran_image)
                                                <img src="{{ $item->lampiran_url }}" alt="{{ $item->judul_laporan }}" class="h-full w-full object-cover">
                                            @else
                                                <i class="fas fa-image text-slate-400"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800">{{ $item->judul_laporan }}</p>
                                            <p class="mt-1 text-sm text-slate-500">{{ $item->nama_pelapor }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-600">{{ $item->kategori }}</td>

                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <p>{{ Str::limit($item->lokasi, 60) }}</p>
                                    <p class="mt-1 text-xs text-slate-400">{{ optional($item->tanggal_kejadian)->format('d M Y') }}</p>
                                </td>

                                @unless($historyMode)
                                    <td class="px-6 py-4">
                                        @if($item->status === 'pending')
                                            <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">Pending</span>
                                        @elseif($item->status === 'diproses')
                                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Diproses</span>
                                        @endif
                                    </td>
                                @endunless

                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <p>Ditugaskan {{ optional($item->ditugaskan_at)->format('d M Y') ?? '-' }}</p>
                                    <p class="mt-1 text-xs text-slate-400">
                                        @if($item->status === 'selesai')
                                            Selesai {{ optional($item->selesai_at)->format('d M Y H:i') ?? '-' }}
                                        @elseif($item->status === 'diproses')
                                            Diproses {{ optional($item->diproses_at)->format('d M Y H:i') ?? '-' }}
                                        @else
                                            Menunggu tindak lanjut
                                        @endif
                                    </p>
                                </td>

                                <td class="px-6 py-4">
                                    <a href="{{ $historyMode ? route('operator.laporan.history.show', $item) : route('operator.laporan.show', $item) }}"
                                       class="inline-flex items-center rounded-2xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                                        {{ $historyMode ? 'Lihat Detail' : 'Proses' }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-16 text-center text-slate-500">
                    <i class="fas fa-inbox mb-4 text-4xl text-slate-300"></i>
                    <p>{{ $emptyState }}</p>
                </div>
            @endif
        </div>

        <div class="border-t border-slate-100 px-6 py-4">
            {{ $laporan->links() }}
        </div>
    </div>
</div>
@endsection
