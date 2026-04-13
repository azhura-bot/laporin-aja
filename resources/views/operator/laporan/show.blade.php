@extends('layouts.operator')

@section('page-title', 'Detail Laporan')
@section('page-description', 'Tinjau laporan, perbarui progres, dan unggah bukti penanganan.')

@section('operator-content')
<div class="fade-in space-y-6">
    <div>
        <a href="{{ route('operator.laporan.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-800">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Laporan Saya
        </a>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
                <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-600">#{{ $laporan->id }}</p>
                        <h2 class="text-xl font-bold text-slate-800">{{ $laporan->judul_laporan }}</h2>
                        <p class="mt-1 text-sm text-slate-500">{{ $laporan->kategori }} | {{ $laporan->nama_pelapor }}</p>
                    </div>

                    @if($laporan->status === 'pending')
                        <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-sm font-semibold text-yellow-700">Pending</span>
                    @elseif($laporan->status === 'diproses')
                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">Diproses</span>
                    @else
                        <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-700">Selesai</span>
                    @endif
                </div>
            </div>

            <div class="space-y-6 p-6">
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <p class="text-sm text-slate-500">Lokasi</p>
                        <p class="mt-1 font-medium text-slate-800">{{ $laporan->lokasi }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Tanggal Kejadian</p>
                        <p class="mt-1 font-medium text-slate-800">{{ optional($laporan->tanggal_kejadian)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Kontak Pelapor</p>
                        <p class="mt-1 font-medium text-slate-800">{{ $laporan->no_hp }} | {{ $laporan->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Ditugaskan</p>
                        <p class="mt-1 font-medium text-slate-800">{{ optional($laporan->ditugaskan_at)->format('d F Y H:i') ?? '-' }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Deskripsi Laporan</p>
                    <p class="mt-2 leading-7 text-slate-700">{{ $laporan->deskripsi }}</p>
                </div>

                @if($laporan->lampiran)
                    <div>
                        <p class="text-sm text-slate-500">Lampiran Pelapor</p>
                        <div class="mt-3 overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            @if($laporan->is_lampiran_image)
                                <img src="{{ $laporan->lampiran_url }}" alt="Lampiran pelapor" class="max-h-[420px] w-full rounded-2xl object-contain">
                            @else
                                <a href="{{ $laporan->lampiran_url }}" target="_blank" class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                                    <i class="fas fa-download"></i>
                                    Buka Lampiran
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                @if($laporan->catatan_operator)
                    <div class="rounded-3xl border border-emerald-100 bg-emerald-50 p-4">
                        <p class="text-sm font-semibold text-emerald-800">Catatan Operator Saat Ini</p>
                        <p class="mt-2 text-sm leading-6 text-emerald-900">{{ $laporan->catatan_operator }}</p>
                    </div>
                @endif

                @if($laporan->bukti_penanganan)
                    <div>
                        <p class="text-sm text-slate-500">Bukti Penanganan</p>
                        <div class="mt-3 overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            @if($laporan->is_bukti_penanganan_image)
                                <img src="{{ $laporan->bukti_penanganan_url }}" alt="Bukti penanganan" class="max-h-[420px] w-full rounded-2xl object-contain">
                            @else
                                <a href="{{ $laporan->bukti_penanganan_url }}" target="_blank" class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                                    <i class="fas fa-download"></i>
                                    Buka Bukti Penanganan
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            @if($laporan->status === 'pending')
                <div class="rounded-3xl border border-yellow-200 bg-yellow-50 p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-yellow-800">Tahap 1: Mulai Proses</h3>
                    <p class="mt-1 text-sm text-yellow-700">Laporan masih pending. Klik tombol di bawah untuk mulai memproses laporan ini di lapangan.</p>

                    <form method="POST" action="{{ route('operator.laporan.progress', $laporan) }}" class="mt-5">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="diproses">

                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-yellow-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-yellow-700">
                            Mulai Proses Laporan
                        </button>
                    </form>
                </div>
            @elseif($laporan->status === 'diproses')
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-800">Tahap 2: Update Perkembangan</h3>
                    <p class="mt-1 text-sm text-slate-500">Isi catatan dan unggah bukti saat progres berjalan. Saat sudah tuntas, tandai sebagai selesai.</p>

                    <form method="POST" action="{{ route('operator.laporan.progress', $laporan) }}" enctype="multipart/form-data" class="mt-6 space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Catatan Operator</label>
                            <textarea name="catatan_operator" rows="6" placeholder="Contoh: lokasi sudah dicek, penanganan sementara dilakukan, menunggu tindak lanjut..."
                                      class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-400">{{ old('catatan_operator', $laporan->catatan_operator) }}</textarea>
                            @error('catatan_operator')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Unggah Bukti Penanganan</label>
                            <input type="file" name="bukti_penanganan" accept=".jpg,.jpeg,.png,.webp"
                                   class="block w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-600 file:mr-4 file:rounded-xl file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:font-semibold file:text-blue-600 hover:file:bg-blue-100">
                            <p class="mt-2 text-xs text-slate-400">Format: JPG, JPEG, PNG, WEBP. Maksimal 4 MB.</p>
                            @error('bukti_penanganan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @error('status')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <div class="grid grid-cols-1 gap-3">
                            <button type="submit" name="status" value="diproses" class="inline-flex w-full items-center justify-center rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                                Simpan Perkembangan
                            </button>
                            <button type="submit" name="status" value="selesai" class="inline-flex w-full items-center justify-center rounded-2xl bg-green-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-green-700">
                                Tandai Selesai
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="rounded-3xl border border-green-200 bg-green-50 p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-green-800">Laporan Sudah Selesai</h3>
                    <p class="mt-1 text-sm text-green-700">Laporan ini sudah ditutup, sehingga perkembangan tidak bisa dikirim ulang.</p>
                    <p class="mt-3 text-xs text-green-700">Waktu selesai: {{ optional($laporan->selesai_at)->format('d F Y H:i') ?? '-' }}</p>
                </div>
            @endif

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-800">Timeline</h3>
                <div class="mt-5 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="mt-1 flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-inbox text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-slate-800">Laporan Masuk</p>
                            <p class="text-sm text-slate-500">{{ $laporan->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="mt-1 flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-indigo-600">
                            <i class="fas fa-user-check text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-slate-800">Ditugaskan ke Operator</p>
                            <p class="text-sm text-slate-500">{{ optional($laporan->ditugaskan_at)->format('d F Y H:i') ?? 'Belum ditugaskan' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="mt-1 flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                            <i class="fas fa-gears text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-slate-800">Mulai Diproses</p>
                            <p class="text-sm text-slate-500">{{ optional($laporan->diproses_at)->format('d F Y H:i') ?? 'Belum diproses' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="mt-1 flex h-9 w-9 items-center justify-center rounded-full bg-cyan-100 text-cyan-600">
                            <i class="fas fa-circle-check text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-slate-800">Selesai</p>
                            <p class="text-sm text-slate-500">{{ optional($laporan->selesai_at)->format('d F Y H:i') ?? 'Belum selesai' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
