<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Services\MediaStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function __construct(
        private readonly MediaStorageService $mediaStorage
    ) {
    }

    public function index(Request $request)
    {
        $laporan = $this->buildQuery($request, false)
            ->paginate(10)
            ->withQueryString();

        return view('operator.laporan.index', [
            'laporan' => $laporan,
            'pageTitle' => 'Laporan Saya',
            'pageDescription' => 'Kelola laporan yang ditugaskan kepada Anda.',
            'emptyState' => 'Belum ada laporan yang ditugaskan ke Anda.',
            'historyMode' => false,
        ]);
    }

    public function history(Request $request)
    {
        $laporan = $this->buildQuery($request, true)
            ->paginate(10)
            ->withQueryString();

        return view('operator.laporan.index', [
            'laporan' => $laporan,
            'pageTitle' => 'Riwayat Penanganan',
            'pageDescription' => 'Lihat arsip laporan yang sudah Anda tangani.',
            'emptyState' => 'Belum ada riwayat penanganan laporan.',
            'historyMode' => true,
        ]);
    }

    public function show(Laporan $laporan)
    {
        $laporan = $this->findAssignedLaporan($laporan->id);

        return view('operator.laporan.show', compact('laporan'));
    }

    public function historyShow(Laporan $laporan)
    {
        $laporan = $this->findAssignedLaporan($laporan->id);

        if ($laporan->status !== 'selesai') {
            return redirect()
                ->route('operator.laporan.show', $laporan)
                ->with('error', 'Detail riwayat hanya untuk laporan yang sudah selesai.');
        }

        return view('operator.laporan.history-show', compact('laporan'));
    }

    public function updateProgress(Request $request, Laporan $laporan)
    {
        $laporan = $this->findAssignedLaporan($laporan->id);

        if ($laporan->status === 'selesai') {
            return redirect()
                ->route('operator.laporan.show', $laporan)
                ->with('error', 'Laporan yang sudah selesai tidak bisa diperbarui lagi.');
        }

        $validated = $request->validate([
            'status' => 'required|in:diproses,selesai',
            'catatan_operator' => 'nullable|string|max:5000',
            'bukti_penanganan' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $nextStatus = $validated['status'];
        $currentStatus = $laporan->status;

        if ($currentStatus === 'pending' && $nextStatus !== 'diproses') {
            return back()->with('error', 'Laporan pending harus diproses terlebih dahulu sebelum diselesaikan.');
        }

        if ($currentStatus === 'pending' && $nextStatus === 'diproses') {
            $laporan->status = 'diproses';
            $laporan->diproses_at ??= now();
            $laporan->selesai_at = null;
            $laporan->save();

            return redirect()
                ->route('operator.laporan.show', $laporan)
                ->with('success', 'Laporan berhasil dipindahkan ke status diproses. Anda sekarang bisa mengisi catatan dan bukti penanganan.');
        }

        if ($request->hasFile('bukti_penanganan')) {
            $this->mediaStorage->deleteFile($laporan->bukti_penanganan);
            $laporan->bukti_penanganan = $this->mediaStorage->storeUploadedFile(
                $request->file('bukti_penanganan'),
                'operator-bukti'
            );
        }

        if ($request->filled('catatan_operator')) {
            $laporan->catatan_operator = $validated['catatan_operator'];
        }

        if ($nextStatus === 'diproses') {
            if (! $request->filled('catatan_operator') && ! $request->hasFile('bukti_penanganan')) {
                return back()->with('error', 'Isi catatan operator atau unggah bukti untuk memperbarui progres.');
            }

            $laporan->status = 'diproses';
            $laporan->diproses_at ??= now();
            $laporan->selesai_at = null;
            $laporan->save();

            return redirect()
                ->route('operator.laporan.show', $laporan)
                ->with('success', 'Perkembangan laporan berhasil diperbarui.');
        }

        $hasNote = $request->filled('catatan_operator') || filled($laporan->catatan_operator);
        $hasProof = $request->hasFile('bukti_penanganan') || filled($laporan->bukti_penanganan);

        if (! $hasNote) {
            return back()->with('error', 'Catatan operator wajib diisi sebelum menandai laporan selesai.');
        }

        if (! $hasProof) {
            return back()->with('error', 'Bukti penanganan wajib diunggah sebelum menandai laporan selesai.');
        }

        $laporan->status = 'selesai';
        $laporan->diproses_at ??= now();
        $laporan->selesai_at = now();
        $laporan->save();

        return redirect()
            ->route('operator.laporan.show', $laporan)
            ->with('success', 'Laporan berhasil ditandai selesai.');
    }

    private function buildQuery(Request $request, bool $historyMode)
    {
        $query = Laporan::where('operator_id', Auth::id());

        if ($historyMode) {
            $query->where('status', 'selesai');
        } else {
            $query->whereIn('status', ['pending', 'diproses']);
        }

        if ($search = trim((string) $request->input('search'))) {
            $query->where(function ($builder) use ($search) {
                $builder->where('judul_laporan', 'like', '%' . $search . '%')
                    ->orWhere('nama_pelapor', 'like', '%' . $search . '%')
                    ->orWhere('lokasi', 'like', '%' . $search . '%')
                    ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        if (! $historyMode && ($status = $request->input('status'))) {
            if (in_array($status, ['pending', 'diproses'], true)) {
                $query->where('status', $status);
            }
        }

        if ($kategori = trim((string) $request->input('kategori'))) {
            if ($kategori !== 'semua') {
                $query->where('kategori', $kategori);
            }
        }

        $sort = $request->input('sort', 'terbaru');

        if ($sort === 'terlama') {
            return $query->orderBy('created_at');
        }

        if ($sort === 'status') {
            return $query
                ->orderByRaw("FIELD(status, 'pending', 'diproses', 'selesai')")
                ->orderByDesc('ditugaskan_at');
        }

        return $query->orderByDesc('ditugaskan_at')->orderByDesc('created_at');
    }

    private function findAssignedLaporan(int $id): Laporan
    {
        return Laporan::where('operator_id', Auth::id())
            ->findOrFail($id);
    }

}
