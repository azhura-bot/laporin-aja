<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $baseQuery = Laporan::where('operator_id', $user->id);

        $totalLaporan = (clone $baseQuery)->count();
        $laporanPending = (clone $baseQuery)->where('status', 'pending')->count();
        $laporanDiproses = (clone $baseQuery)->where('status', 'diproses')->count();
        $laporanSelesai = (clone $baseQuery)->where('status', 'selesai')->count();

        $laporanAktif = (clone $baseQuery)
            ->whereIn('status', ['pending', 'diproses'])
            ->latest('ditugaskan_at')
            ->take(6)
            ->get();

        $riwayatTerbaru = (clone $baseQuery)
            ->where('status', 'selesai')
            ->latest('selesai_at')
            ->take(5)
            ->get();

        return view('operator.dashboard', compact(
            'totalLaporan',
            'laporanPending',
            'laporanDiproses',
            'laporanSelesai',
            'laporanAktif',
            'riwayatTerbaru'
        ));
    }
}
