<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;

class AnalisisController extends Controller
{

    public function index()
    {
        // Statistik per kategori
        $statistikKategori = Laporan::selectRaw('kategori, COUNT(*) as total')
            ->groupBy('kategori')
            ->get();
        
        // Statistik per status
        $statistikStatus = Laporan::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();
        
        // Statistik per bulan
        $statistikBulan = Laporan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        
        // Top 5 kategori terbanyak
        $topKategori = $statistikKategori->sortByDesc('total')->take(5);
        
        // Total keseluruhan
        $totalLaporan = Laporan::count();
        $totalWarga = User::where('role', 'user')->count();
        $rataRataPerHari = round(Laporan::whereDate('created_at', today())->count(), 2);
        
        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $bulanData = array_fill(0, 12, 0);
        
        foreach ($statistikBulan as $item) {
            $bulanData[$item->bulan - 1] = $item->total;
        }
        
        return view('admin.analisis', compact(
            'statistikKategori', 'statistikStatus', 'topKategori',
            'totalLaporan', 'totalWarga', 'rataRataPerHari',
            'bulanLabels', 'bulanData'
        ));
    }
}