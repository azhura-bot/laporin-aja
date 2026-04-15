<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\User;
use App\Services\MediaStorageService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LaporanController extends Controller
{
    public function __construct(
        private readonly MediaStorageService $mediaStorage
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporan = Laporan::with('operator:id,name')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.laporan.index', compact('laporan'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $laporan = Laporan::with(['operator:id,name,email,no_hp', 'tanggapans.user:id,name'])
            ->findOrFail($id);
        $operators = User::where('role', 'operator')
            ->where('status', 'aktif')
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'no_hp']);

        return view('admin.laporan.show', compact('laporan', 'operators'));
    }

    /**
     * Update status laporan.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai',
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->status = $request->status;
        $this->syncStatusTimestamps($laporan, $request->status);
        $laporan->save();

        return redirect()->back()->with('success', 'Status laporan berhasil diupdate');
    }

    public function assignOperator(Request $request, $id)
    {
        $validated = $request->validate([
            'operator_id' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id')->where(fn ($query) => $query
                    ->where('role', 'operator')
                    ->where('status', 'aktif')),
            ],
        ]);

        $laporan = Laporan::findOrFail($id);
        $operatorId = $validated['operator_id'] ?? null;
        $assignmentChanged = $laporan->operator_id !== $operatorId;

        $laporan->operator_id = $operatorId;
        $laporan->ditugaskan_at = $operatorId && $assignmentChanged
            ? now()
            : ($operatorId ? $laporan->ditugaskan_at : null);
        $laporan->save();

        $message = $operatorId
            ? 'Operator berhasil ditugaskan ke laporan.'
            : 'Penugasan operator berhasil dibatalkan.';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);

        $this->mediaStorage->deleteFile($laporan->lampiran);
        $this->mediaStorage->deleteFile($laporan->bukti_penanganan);

        $laporan->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dihapus');
    }

    private function syncStatusTimestamps(Laporan $laporan, string $status): void
    {
        if ($status === 'pending') {
            $laporan->diproses_at = null;
            $laporan->selesai_at = null;

            return;
        }

        if ($status === 'diproses') {
            $laporan->diproses_at ??= now();
            $laporan->selesai_at = null;

            return;
        }

        $laporan->diproses_at ??= now();
        $laporan->selesai_at = now();
    }
}
