<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LiburNasional;
use Illuminate\Http\Request;

class LiburNasionalController extends Controller
{
    public function index(Request $request)
    {
        $liburNasionals = LiburNasional::query();

        if ($request->has('bulan')) {
            $liburNasionals->whereMonth('tanggal', date('m', strtotime($request->bulan)));
        }

        $liburNasionals = $liburNasionals->get();

        return view('backend.master.libur_nasional', compact('liburNasionals'));
    }

    public function create()
    {
        return view('backend.master.libur_nasional');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
        ]);

        LiburNasional::create($request->all());

        return redirect()->route('libur.index')->with('success', 'Data libur nasional berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $dinas = LiburNasional::find($id);
        $dinas->delete();
        return redirect()->route('libur.index')->with('success', 'Data Libur berhasil dihapus!');
    }

    public function filter(Request $request)
    {
        $liburNasionals = LiburNasional::query();

        // Filter berdasarkan bulan jika bulan dipilih
        if ($request->has('bulan')) {
            $liburNasionals->whereMonth('tanggal', date('m', strtotime($request->bulan)));
        }

        $liburNasionals = $liburNasionals->get();

        return view('backend.master.libur_nasional', compact('liburNasionals'));
    }
}
