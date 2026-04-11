<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DaerahButuhRelawan;
use Illuminate\Http\Request;

class DaerahButuhRelawanController extends Controller
{
    public function index(Request $request)
    {
        $query = DaerahButuhRelawan::with('relawans');

        // Filter provinsi
        if ($request->provinsi) {
            $query->where('provinsi', $request->provinsi);
        }

        // Filter prioritas
        if ($request->prioritas && $request->prioritas != 'semua') {
            $query->where('prioritas', $request->prioritas);
        }

        // Filter status aktif
        if ($request->status && $request->status != 'semua') {
            $query->where('aktif', $request->status == 'aktif');
        }

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_daerah', 'like', '%' . $request->search . '%')
                  ->orWhere('provinsi', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        $daerahList = $query->latest()->paginate(15);

        // Statistik
        $totalDaerah = DaerahButuhRelawan::count();
        $daerahAktif = DaerahButuhRelawan::where('aktif', true)->count();
        $daerahKritis = DaerahButuhRelawan::where('prioritas', 'kritis')->where('aktif', true)->count();

        // Daftar provinsi untuk filter
        $provinsiList = DaerahButuhRelawan::select('provinsi')->distinct()->pluck('provinsi');

        return view('admin.daerah-butuh-relawan.index', compact(
            'daerahList', 'totalDaerah', 'daerahAktif', 'daerahKritis', 'provinsiList'
        ));
    }

    public function create()
    {
        return view('admin.daerah-butuh-relawan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_daerah' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi,kritis',
            'relawan_dibutuhkan' => 'required|integer|min:1',
            'aktif' => 'required|boolean'
        ]);

        // Convert to true boolean ("0" or "1" strings)
        $validated['aktif'] = $validated['aktif'] == '1';
        
        DaerahButuhRelawan::create($validated);

        return redirect()->route('admin.daerah-butuh-relawan.index')
                         ->with('success', 'Daerah berhasil ditambahkan!');
    }

    public function show($id)
    {
        $daerah = DaerahButuhRelawan::with('relawans.user')->findOrFail($id);
        return view('admin.daerah-butuh-relawan.show', compact('daerah'));
    }

    public function edit($id)
    {
        $daerah = DaerahButuhRelawan::findOrFail($id);
        return view('admin.daerah-butuh-relawan.edit', compact('daerah'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_daerah' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi,kritis',
            'relawan_dibutuhkan' => 'required|integer|min:1',
            'aktif' => 'required|boolean'
        ]);

        // Convert to true boolean ("0" or "1" strings)
        $validated['aktif'] = $validated['aktif'] == '1';

        $daerah = DaerahButuhRelawan::findOrFail($id);
        $daerah->update($validated);

        return redirect()->route('admin.daerah-butuh-relawan.index')
                         ->with('success', 'Daerah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $daerah = DaerahButuhRelawan::findOrFail($id);
        $daerah->delete();

        return redirect()->route('admin.daerah-butuh-relawan.index')
                         ->with('success', 'Daerah berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $daerah = DaerahButuhRelawan::findOrFail($id);
        $daerah->aktif = !$daerah->aktif;
        $daerah->save();

        $status = $daerah->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Daerah berhasil {$status}!");
    }
}
