<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Tambahkan untuk debugging

class LaporanController extends Controller
{

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

        // Upload file
        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $lampiranPath = $file->storeAs('lampiran', $fileName, 'public');
        }

        // Simpan ke database
        try {
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
        } catch (\Exception $e) {
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
        
        // Upload file baru
        if ($request->hasFile('lampiran')) {
            if ($laporan->lampiran && Storage::disk('public')->exists($laporan->lampiran)) {
                Storage::disk('public')->delete($laporan->lampiran);
            }
            
            $file = $request->file('lampiran');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $lampiranPath = $file->storeAs('lampiran', $fileName, 'public');
            $validated['lampiran'] = $lampiranPath;
        }
        
        $laporan->update($validated);
        
        return redirect()->route('laporan.show', $laporan->id)
                         ->with('success', 'Laporan berhasil diperbarui!');
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
        
        // Hapus file lampiran
        if ($laporan->lampiran && Storage::disk('public')->exists($laporan->lampiran)) {
            Storage::disk('public')->delete($laporan->lampiran);
        }
        
        $laporan->delete();
        
        return redirect()->route('laporan.index')
                         ->with('success', 'Laporan berhasil dihapus!');
    }
}