<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class KelolaStatusController extends Controller
{

    public function index()
    {
        $laporan = Laporan::latest()->paginate(15);
        
        $pendingCount = Laporan::where('status', 'pending')->count();
        $diprosesCount = Laporan::where('status', 'diproses')->count();
        $selesaiCount = Laporan::where('status', 'selesai')->count();
        
        return view('admin.kelola-status', compact('laporan', 'pendingCount', 'diprosesCount', 'selesaiCount'));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->status = $request->status;
        $laporan->save();
        
        return redirect()->back()->with('success', 'Status laporan berhasil diubah!');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'laporan_ids' => 'required|array',
            'laporan_ids.*' => 'required|integer|exists:laporans,id',
            'status' => 'required|in:pending,diproses,selesai'
        ]);

        $updatedCount = Laporan::whereIn('id', $request->laporan_ids)
            ->update(['status' => $request->status]);

        return redirect()->back()->with('success', "Status {$updatedCount} laporan berhasil diubah!");
    }
}