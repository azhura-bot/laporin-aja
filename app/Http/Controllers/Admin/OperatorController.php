<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller
{

    public function index(Request $request)
    {
        $query = User::where('role', 'operator');
        
        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('no_hp', 'like', '%' . $request->search . '%');
            });
        }
        
        $operators = $query->latest()->paginate(10);
        
        // Statistik
        $totalOperators = User::where('role', 'operator')->count();
        $totalActive = User::where('role', 'operator')->where('status', 'aktif')->count();
        $totalInactive = User::where('role', 'operator')->where('status', 'nonaktif')->count();
        
        return view('admin.operator.index', compact('operators', 'totalOperators', 'totalActive', 'totalInactive'));
    }

    public function create()
    {
        return view('admin.operator.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'operator',
            'status' => 'aktif',
        ]);

        return redirect()->route('admin.operator.index')
                         ->with('success', 'Operator lapangan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $operator = User::where('role', 'operator')->findOrFail($id);
        return view('admin.operator.edit', compact('operator'));
    }

    public function update(Request $request, $id)
    {
        $operator = User::where('role', 'operator')->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_hp' => 'required|string|max:15',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ];
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        $operator->update($data);

        return redirect()->route('admin.operator.index')
                         ->with('success', 'Operator lapangan berhasil diupdate!');
    }

    public function updateStatus(Request $request, $id)
    {
        $operator = User::where('role', 'operator')->findOrFail($id);
        $operator->status = $request->status;
        $operator->save();
        
        return redirect()->back()->with('success', 'Status operator berhasil diubah!');
    }

    public function destroy($id)
    {
        $operator = User::where('role', 'operator')->findOrFail($id);
        $operator->delete();
        
        return redirect()->route('admin.operator.index')
                         ->with('success', 'Operator lapangan berhasil dihapus!');
    }
    
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'status' => 'required|in:aktif,nonaktif'
        ]);
        
        User::whereIn('id', $request->ids)->where('role', 'operator')->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', count($request->ids) . ' operator berhasil diupdate!');
    }
}