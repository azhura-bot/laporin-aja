<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Relawan;
use Illuminate\Http\Request;

class RelawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Relawan::with(['user', 'daerahButuhRelawan']);
        
        // Filter status
        if ($request->status && $request->status != 'semua') {
            $query->where('status', $request->status);
        }
        
        // Filter keahlian
        if ($request->keahlian && $request->keahlian != 'semua') {
            $query->where('keahlian', $request->keahlian);
        }
        
        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('no_hp', 'like', '%' . $request->search . '%')
                  ->orWhere('domisili', 'like', '%' . $request->search . '%');
            });
        }
        
        $relawans = $query->latest()->paginate(15);
        
        // Statistik
        $totalRelawan = Relawan::count();
        $totalPending = Relawan::where('status', 'pending')->count();
        $totalAktif = Relawan::where('status', 'aktif')->count();
        $totalNonaktif = Relawan::where('status', 'nonaktif')->count();
        
        // Daftar keahlian untuk filter
        $keahlianList = Relawan::select('keahlian')->distinct()->pluck('keahlian');
        $activeSkills = Relawan::where('status', 'aktif')->select('keahlian')->distinct()->pluck('keahlian');
        
        return view('admin.relawan.index', compact('relawans', 'totalRelawan', 'totalPending', 'totalAktif', 'totalNonaktif', 'keahlianList', 'activeSkills'));
    }

    public function show($id)
    {
        $relawan = Relawan::with(['user', 'daerahButuhRelawan'])->findOrFail($id);
        return view('admin.relawan.show', compact('relawan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,aktif,nonaktif'
        ]);
        
        $relawan = Relawan::findOrFail($id);
        $relawan->status = $request->status;
        $relawan->save();
        
        return redirect()->back()->with('success', 'Status relawan berhasil diupdate!');
    }
    
    public function destroy($id)
    {
        $relawan = Relawan::findOrFail($id);
        $relawan->delete();
        
        return redirect()->route('admin.relawan.index')->with('success', 'Relawan berhasil dihapus!');
    }
    
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'status' => 'required|in:pending,aktif,nonaktif'
        ]);
        
        Relawan::whereIn('id', $request->ids)->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', count($request->ids) . ' relawan berhasil diupdate!');
    }
}