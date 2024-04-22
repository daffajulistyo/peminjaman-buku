<?php

namespace App\Http\Controllers\Backend;

use App\Models\Opd;
use App\Models\Koordinat;
use Illuminate\Http\Request;
use App\Models\AktifKoordinat;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KoordinatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Koordinat::query();

        // Filter berdasarkan pencarian nama opd
        if ($request->has('nama')) {
            $query->whereHas('opd', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->nama . '%');
            });
        }

        // Filter berdasarkan peran pengguna dan opd_id
        if (Auth::user()->role == 1) {
            $query->where('opd_id', Auth::user()->opd_id);
        }

        $koordinat = $query->paginate(10);

        return view('backend.koordinat.list_koordinat', compact('koordinat'));
    }


    public function create()
    {
        $opds = Opd::all();
        return view('backend.koordinat.create_koordinat', compact('opds'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'alamat' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'opd_id' => 'nullable|exists:opds,id',
        ]);

        Koordinat::create($validatedData);

        return redirect()->route('koordinat.index')
            ->with('success', 'Koordinat created successfully!');
    }


    public function show($id)
    {
        $koordinat = Koordinat::find($id);
        return view('backend.koordinat.show', compact('koordinat'));
    }

    public function edit($id)
    {
        $koordinat = Koordinat::find($id);
        $opds = Opd::all();

        return view('backend.koordinat.edit_koordinat', compact('koordinat', 'opds'));
    }

    public function update(Request $request, $id)
    {
        $koordinat = Koordinat::find($id);
        $koordinat->update($request->all());
        return redirect()->route('koordinat.index')->with('success', 'Koordinat updated successfully!');
    }

    public function destroy($id)
    {
        $koordinat = Koordinat::find($id);
        $koordinat->delete();
        return redirect()->route('koordinat.index')->with('success', 'Koordinat deleted successfully!');
    }

    public function pickLocation()
    {
        return view('backend.koordinat.pick_location');
    }

    public function getLatitudeLongitude()
    {
        $user = Auth::user();

        if ($user) {
            $latitude = $user->opd->koordinat->latitude; // Akses latitude melalui relasi
            $longitude = $user->opd->koordinat->longitude; // Akses longitude melalui relasi

        }
    }

    public function toggleKoordinat(Request $request)
    {
        try {
            $koordinat = AktifKoordinat::latest()->first();

            $koordinat->active = !$koordinat->active;
            $koordinat->save();

            return redirect()->back()->with('success', 'Status koordinat berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah status koordinat: ' . $e->getMessage());
        }
    }
}
