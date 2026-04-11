<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Relawan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Statistik
        $totalLaporan = Laporan::count();
        $laporanPending = Laporan::where('status', 'pending')->count();
        $laporanDiproses = Laporan::where('status', 'diproses')->count();
        $laporanSelesai = Laporan::where('status', 'selesai')->count();
        
        $totalRelawan = Relawan::count();
        $relawanPending = Relawan::where('status', 'pending')->count();
        $relawanAktif = Relawan::where('status', 'aktif')->count();
        
        $totalUsers = User::where('role', 'user')->count();
        
        // Laporan terbaru
        $laporanTerbaru = Laporan::latest()->paginate(10);
        
        // Relawan terbaru
        $relawanTerbaru = Relawan::latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalLaporan', 'laporanPending', 'laporanDiproses', 'laporanSelesai',
            'totalRelawan', 'relawanPending', 'relawanAktif',
            'totalUsers', 'laporanTerbaru', 'relawanTerbaru'
        ));
    }
}