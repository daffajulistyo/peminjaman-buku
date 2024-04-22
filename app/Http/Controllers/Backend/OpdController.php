<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use Illuminate\Http\Request;
use App\Models\Bidang;
use App\Models\Jabatan;
use RealRashid\SweetAlert\Facades\Alert;

class OpdController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Opd::query();

        // Filter berdasarkan pencarian
        if ($request->has('nama')) {
            $query->where('name', 'like', '%' . $request->nama . '%');
        }


        $opd = $query->paginate(10);

        return view('backend.opd.list_opd', compact('opd'));
    }

    public function create()
    {
        return view('backend.opd.create_opd');
    }

    public function store(Request $request)
    {
        $opd = new Opd($request->all());
        $opd->save();

        return redirect()->route('opd.index')->with('success', 'Data Opd berhasil ditambahkan!');
    }

    public function show($id)
    {
        $opd = Opd::find($id);
        return view('backend.opd.show', compact('opd'));
    }

    public function edit($id)
    {
        $opd = Opd::find($id);
        return view('backend.opd.edit_opd', compact('opd'));
    }

    public function update(Request $request, $id)
    {
        $opd = Opd::find($id);
        $opd->update($request->all());
        return redirect()->route('opd.index')->with('success', 'Data Opd berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $opd = Opd::find($id);
        $opd->delete();
        return redirect()->route('opd.index')->with('success', 'Data Opd berhasil dihapus!');
    }


    public function getBidangs($opdId)
    {
        // Retrieve bidangs based on $opdId
        $bidangs = Bidang::where('opd_id', $opdId)->get();

        // Return the bidangs as JSON response
        return response()->json($bidangs);
    }


    public function getJabatans($opdId)
    {
        // Retrieve jabatans based on $opdId and $bidangId
        $jabatans = Jabatan::where('opd_id', $opdId)->get();

        // Return the jabatans as JSON response
        return response()->json($jabatans);
    }
}
