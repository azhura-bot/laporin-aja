<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Services\MediaStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Tambahkan untuk debugging
use Throwable;

class LaporanController extends Controller
{
    public function __construct(
        private readonly MediaStorageService $mediaStorage
    ) {
    }

    /**
     * Menampilkan semua laporan milik user
     */
    public function index()
    {
        $laporans = Laporan::where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        
        return view('laporan.index', compact('laporans'));
    }

    /**
     * Menampilkan form buat laporan
     */
    public function create()
    {
        $kategoriList = [
            'Infrastruktur' => 'Infrastruktur (Jalan, Jembatan, Drainase)',
            'Kebersihan' => 'Kebersihan (Sampah, Limbah)',
            'Kesehatan' => 'Kesehatan (Fasilitas Kesehatan, Wabah)',
            'Pendidikan' => 'Pendidikan (Sekolah, Fasilitas Belajar)',
            'Keamanan' => 'Keamanan (Kriminalitas, Patroli)',
            'Pelayanan Publik' => 'Pelayanan Publik (Administrasi, Perizinan)',
            'Lingkungan' => 'Lingkungan (Polusi, Penghijauan)',
            'Lainnya' => 'Lainnya'
        ];
        
        return view('laporan.create', compact('kategoriList'));
    }

    /**
     * Menyimpan laporan baru
     */
    public function store(Request $request)
    {
        // Cek apakah user login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $validated = $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'kategori' => 'required|string|max:100',
            'lokasi' => 'required|string|max:500',
            'tanggal_kejadian' => 'required|date',
            'judul_laporan' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120'
        ]);

        // Simpan ke database
        try {
            $lampiranPath = null;

            if ($request->hasFile('lampiran')) {
                $lampiranPath = $this->mediaStorage->storeUploadedFile(
                    $request->file('lampiran'),
                    'lampiran'
                );
            }

            $laporan = Laporan::create([
                'nama_pelapor' => $validated['nama_pelapor'],
                'no_hp' => $validated['no_hp'],
                'email' => $validated['email'],
                'kategori' => $validated['kategori'],
                'lokasi' => $validated['lokasi'],
                'tanggal_kejadian' => $validated['tanggal_kejadian'],
                'judul_laporan' => $validated['judul_laporan'],
                'deskripsi' => $validated['deskripsi'],
                'lampiran' => $lampiranPath,
                'user_id' => Auth::id(),
                'status' => 'pending'
            ]);

            return redirect()->route('laporan.index')
                             ->with('success', 'Laporan berhasil dikirim!');
        } catch (Throwable $e) {
            Log::error('Error saving report: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan saat menyimpan laporan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail laporan
     */
    public function show($id)
    {
        $laporan = Laporan::where('user_id', Auth::id())->findOrFail($id);
        return view('laporan.show', compact('laporan'));
    }

    /**
     * Menampilkan form edit laporan
     */
    public function edit($id)
    {
        $laporan = Laporan::where('user_id', Auth::id())->findOrFail($id);
        
        if ($laporan->status != 'pending') {
            return redirect()->route('laporan.show', $laporan->id)
                             ->with('error', 'Laporan yang sudah diproses tidak dapat diedit!');
        }
        
        $kategoriList = [
            'Infrastruktur' => 'Infrastruktur (Jalan, Jembatan, Drainase)',
            'Kebersihan' => 'Kebersihan (Sampah, Limbah)',
            'Kesehatan' => 'Kesehatan (Fasilitas Kesehatan, Wabah)',
            'Pendidikan' => 'Pendidikan (Sekolah, Fasilitas Belajar)',
            'Keamanan' => 'Keamanan (Kriminalitas, Patroli)',
            'Pelayanan Publik' => 'Pelayanan Publik (Administrasi, Perizinan)',
            'Lingkungan' => 'Lingkungan (Polusi, Penghijauan)',
            'Lainnya' => 'Lainnya'
        ];
        
        return view('laporan.edit', compact('laporan', 'kategoriList'));
    }

    /**
     * Mengupdate laporan
     */
    public function update(Request $request, $id)
    {
        $laporan = Laporan::where('user_id', Auth::id())->findOrFail($id);
        
        if ($laporan->status != 'pending') {
            return redirect()->route('laporan.show', $laporan->id)
                             ->with('error', 'Laporan yang sudah diproses tidak dapat diubah!');
        }
        
        $validated = $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'kategori' => 'required|string|max:100',
            'lokasi' => 'required|string|max:500',
            'tanggal_kejadian' => 'required|date',
            'judul_laporan' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120'
        ]);
        
        try {
            // Upload file baru
            if ($request->hasFile('lampiran')) {
                $this->mediaStorage->deleteFile($laporan->lampiran);
                $validated['lampiran'] = $this->mediaStorage->storeUploadedFile(
                    $request->file('lampiran'),
                    'lampiran'
                );
            }

            $laporan->update($validated);

            return redirect()->route('laporan.show', $laporan->id)
                             ->with('success', 'Laporan berhasil diperbarui!');
        } catch (Throwable $e) {
            Log::error('Error updating report: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui laporan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus laporan
     */
    public function destroy($id)
    {
        $laporan = Laporan::where('user_id', Auth::id())->findOrFail($id);
        
        if ($laporan->status != 'pending') {
            return redirect()->route('laporan.index')
                             ->with('error', 'Laporan yang sudah diproses tidak dapat dihapus!');
        }
        
        try {
            // Hapus file lampiran
            $this->mediaStorage->deleteFile($laporan->lampiran);

            $laporan->delete();

            return redirect()->route('laporan.index')
                             ->with('success', 'Laporan berhasil dihapus!');
        } catch (Throwable $e) {
            Log::error('Error deleting report: ' . $e->getMessage());

            return redirect()->route('laporan.index')
                ->with('error', 'Terjadi kesalahan saat menghapus laporan: ' . $e->getMessage());
        }
    }
}
