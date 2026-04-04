<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{

    public function index()
    {
        $laporan = Laporan::with('user')
            ->latest()
            ->paginate(15);

        $totalLaporan = Laporan::count();
        $pendingCount = Laporan::where('status', 'pending')->count();
        $diprosesCount = Laporan::where('status', 'diproses')->count();
        $selesaiCount = Laporan::where('status', 'selesai')->count();

        return view('admin.laporan.index', compact(
            'laporan',
            'totalLaporan',
            'pendingCount',
            'diprosesCount',
            'selesaiCount'
        ));
    }

    public function create()
    {
        return redirect()->route('admin.dashboard');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.dashboard');
    }

    public function show($id)
    {
        return redirect()->route('admin.dashboard');
    }

    public function edit($id)
    {
        return redirect()->route('admin.dashboard');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.dashboard');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.dashboard');
    }
}
