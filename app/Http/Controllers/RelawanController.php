<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Relawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RelawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $sudahRelawan = Relawan::where('user_id', Auth::id())->exists();
        
        if ($sudahRelawan) {
            return redirect()->route('dashboard')
                             ->with('info', 'Anda sudah terdaftar sebagai relawan!');
        }
        
        return view('relawan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'keahlian' => 'nullable|string|max:255',
            'ketersediaan_waktu' => 'nullable|string|max:100',
            'motivasi' => 'nullable|string'
        ]);

        $sudahRelawan = Relawan::where('user_id', Auth::id())->exists();
        
        if ($sudahRelawan) {
            return redirect()->route('dashboard')
                             ->with('error', 'Anda sudah terdaftar sebagai relawan!');
        }

        Relawan::create([
            'user_id' => Auth::id(),
            'nama_lengkap' => $validated['nama_lengkap'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'keahlian' => $validated['keahlian'] ?? null,
            'ketersediaan_waktu' => $validated['ketersediaan_waktu'] ?? null,
            'motivasi' => $validated['motivasi'] ?? null,
            'status' => 'pending'
        ]);

        return redirect()->route('dashboard')
                         ->with('success', 'Pendaftaran relawan berhasil! Menunggu verifikasi admin.');
    }
}