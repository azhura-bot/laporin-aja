<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;

class BalasWargaController extends Controller
{

    public function index()
    {
        // Laporan yang belum ada tanggapannya
        $laporanBelumDibalas = Laporan::whereDoesntHave('tanggapan')
            ->with('user')
            ->latest()
            ->get();
        
        // Hitung statistik
        $belumDibalasCount = $laporanBelumDibalas->count();
        $sudahDibalasCount = Laporan::whereHas('tanggapan')->count();
        $totalTanggapan = Tanggapan::count();
        
        // Tanggapan terbaru
        $tanggapanTerbaru = Tanggapan::with(['laporan', 'user'])
            ->latest()
            ->take(10)
            ->get();
        
        return view('admin.balas-warga', compact(
            'laporanBelumDibalas', 
            'belumDibalasCount', 
            'sudahDibalasCount', 
            'totalTanggapan',
            'tanggapanTerbaru'
        ));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'isi_tanggapan' => 'required|string|min:10',
            'status_laporan' => 'required|in:pending,diproses,selesai'
        ]);
        
        $laporan = Laporan::findOrFail($id);
        
        // Update status laporan jika diperlukan
        if ($request->status_laporan !== $laporan->status) {
            $laporan->status = $request->status_laporan;
            $laporan->save();
        }
        
        Tanggapan::create([
            'laporan_id' => $id,
            'user_id' => auth()->id(),
            'isi_tanggapan' => $request->isi_tanggapan
        ]);
        
        return redirect()->back()->with('success', 'Tanggapan berhasil dikirim ke warga!');
    }
}