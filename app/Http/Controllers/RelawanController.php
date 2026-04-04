<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Relawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RelawanController extends Controller
{

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
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:15',
            'domisili' => 'required|string|max:255',
            'keahlian' => 'required|string|max:255',
            'motivasi' => 'nullable|string|min:20',
            'syarat_setuju' => 'required|accepted'
        ]);

        $sudahRelawan = Relawan::where('user_id', Auth::id())->exists();
        
        if ($sudahRelawan) {
            return redirect()->route('dashboard')
                             ->with('error', 'Anda sudah terdaftar sebagai relawan!');
        }

        Relawan::create([
            'user_id' => Auth::id(),
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'domisili' => $validated['domisili'],
            'keahlian' => $validated['keahlian'],
            'motivasi' => $validated['motivasi'] ?? null,
            'status' => 'pending'
        ]);

        return redirect()->route('dashboard')
                         ->with('success', 'Pendaftaran relawan berhasil! Menunggu verifikasi admin.');
    }
}