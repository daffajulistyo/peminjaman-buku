<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TugasBelajar;
use App\Models\User;
use Illuminate\Http\Request;

class TugasBelajarController extends Controller
{
    public function index(Request $request)
    {

        $query = TugasBelajar::query();

        if ($request->has('nama')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->nama . '%');
            });
        }

        $tugasBelajar = $query->paginate(10);

        return view('backend.tugas_belajar', compact('tugasBelajar'));
    }

    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string',
        ]);

        // Mendapatkan user yang akan ditugaskan
        $user = User::findOrFail($request->user_id);

        // Membuat tugas belajar
        $tugasBelajar = new TugasBelajar();
        $tugasBelajar->fill($request->all());
        $tugasBelajar->opd_id = $user->opd_id;
        $tugasBelajar->jabatan_id = $user->jabatan_id;
        $tugasBelajar->save();

        return redirect()->route('tugas.index')->with('success', 'Tugas belajar berhasil dibuat.');
    }

    public function update(Request $request, $id)
{
    // Validasi request
    $request->validate([
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'keterangan' => 'required|string',
    ]);

    $tugasBelajar = TugasBelajar::findOrFail($id);

    $tugasBelajar->update($request->all());

    return redirect()->route('tugas.index')->with('success', 'Tugas belajar berhasil diperbarui.');
}


    public function destroy($id)
    {
        $tugasBelajar = TugasBelajar::find($id);
        $tugasBelajar->delete();
        return redirect()->route('tugas.index')->with('success', 'Tugas Belajar berhasil dihapus!');
    }
}
