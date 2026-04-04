<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        
        // Statistik sederhana
        $totalLaporan = Laporan::where('user_id', $user->id)->count();
        $laporanPending = Laporan::where('user_id', $user->id)->where('status', 'pending')->count();
        $laporanDiproses = Laporan::where('user_id', $user->id)->where('status', 'diproses')->count();
        $laporanSelesai = Laporan::where('user_id', $user->id)->where('status', 'selesai')->count();
        
        // Laporan terbaru
        $laporanTerbaru = Laporan::where('user_id', $user->id)->latest()->take(5)->get();
        
        return view('dashboard', compact(
            'totalLaporan', 
            'laporanPending', 
            'laporanDiproses', 
            'laporanSelesai', 
            'laporanTerbaru'
        ));
    }
}