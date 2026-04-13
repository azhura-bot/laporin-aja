@extends('layouts.operator')

@section('page-title', 'Detail Riwayat')
@section('page-description', 'Ringkasan laporan selesai yang sudah Anda tangani.')

@section('operator-content')
<div class="fade-in space-y-6">
    <div>
        <a href="{{ route('operator.laporan.history') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-800">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Riwayat
        </a>
    </div>

    <div class="rounded-2xl border border-blue-100 bg-white shadow-md overflow-hidden">
        <div class="border-b px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-lg font-bold text-gray-800">
                <i class="fas fa-timeline mr-2 text-blue-500"></i>
                Timeline Penanganan Laporan
            </h2>
            <p class="text-sm text-gray-500 mt-1">ID #{{ $laporan->id }} - {{ $laporan->judul_laporan }}</p>
        </div>
        <div class="p-6">
            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <p class="text-sm font-semibold text-gray-700">Laporan Dibuat</p>
                    <p class="mt-2 text-sm text-gray-600">{{ $laporan->created_at->format('d M Y H:i') }}</p>
                </div>
                <div class="rounded-xl border border-blue-200 bg-blue-50 p-4">
                    <p class="text-sm font-semibold text-blue-700">Mulai Diproses</p>
                    <p class="mt-2 text-sm text-blue-700">{{ optional($laporan->diproses_at)->format('d M Y H:i') ?? '-' }}</p>
                </div>
                <div class="rounded-xl border border-green-200 bg-green-50 p-4">
                    <p class="text-sm font-semibold text-green-700">Selesai</p>
                    <p class="mt-2 text-sm text-green-700">{{ optional($laporan->selesai_at)->format('d M Y H:i') ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="rounded-2xl border border-slate-200 bg-white shadow-md overflow-hidden">
            <div class="border-b px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-file-alt mr-2 text-blue-500"></i>
                    Laporan Dari Warga
                </h3>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <p class="text-sm text-gray-500">Judul</p>
                    <p class="mt-1 font-semibold text-gray-800">{{ $laporan->judul_laporan }}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Pelapor</p>
                        <p class="mt-1 font-medium text-gray-800">{{ $laporan->nama_pelapor }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Kategori</p>
                        <p class="mt-1 font-medium text-gray-800">{{ $laporan->kategori }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Kontak</p>
                        <p class="mt-1 font-medium text-gray-800">{{ $laporan->no_hp }} | {{ $laporan->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Kejadian</p>
                        <p class="mt-1 font-medium text-gray-800">{{ optional($laporan->tanggal_kejadian)->format('d M Y') ?? '-' }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Lokasi</p>
                    <p class="mt-1 font-medium text-gray-800">{{ $laporan->lokasi }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Deskripsi</p>
                    <p class="mt-1 text-gray-700 leading-7">{{ $laporan->deskripsi }}</p>
                </div>

                @if($laporan->lampiran)
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Lampiran Warga</p>
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            @if($laporan->is_lampiran_image)
                                <img src="{{ $laporan->lampiran_url }}" alt="Lampiran warga" class="max-h-[320px] w-full rounded-lg object-contain">
                            @else
                                <a href="{{ $laporan->lampiran_url }}" target="_blank" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                                    <i class="fas fa-download"></i>
                                    Buka Lampiran
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-md overflow-hidden">
            <div class="border-b px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-reply mr-2 text-green-500"></i>
                    Jawaban Operator
                </h3>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <p class="text-sm text-gray-500">Operator</p>
                    <p class="mt-1 font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Status Akhir</p>
                    <span class="mt-2 inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Selesai</span>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Catatan Operator</p>
                    @if($laporan->catatan_operator)
                        <div class="mt-2 rounded-xl border border-green-100 bg-green-50 p-4">
                            <p class="text-sm leading-7 text-green-900">{{ $laporan->catatan_operator }}</p>
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-500">Tidak ada catatan operator.</p>
                    @endif
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-2">Bukti Penanganan</p>
                    @if($laporan->bukti_penanganan)
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            @if($laporan->is_bukti_penanganan_image)
                                <img src="{{ $laporan->bukti_penanganan_url }}" alt="Bukti penanganan" class="max-h-[320px] w-full rounded-lg object-contain">
                            @else
                                <a href="{{ $laporan->bukti_penanganan_url }}" target="_blank" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                                    <i class="fas fa-download"></i>
                                    Buka Bukti Penanganan
                                </a>
                            @endif
                        </div>
                    @else
                        <p class="text-sm text-gray-500">Tidak ada bukti penanganan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
