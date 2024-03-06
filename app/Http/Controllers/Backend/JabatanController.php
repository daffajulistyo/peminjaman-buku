<?php

namespace App\Http\Controllers\Backend;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Jabatan::query();

        // Filter berdasarkan pencarian
        if ($request->has('nama')) {
            $query->where('name', 'like', '%' . $request->nama . '%');
        }

        // Filter berdasarkan peran pengguna dan opd_id
        if (Auth::user()->role == 1) {
            $query->where('opd_id', Auth::user()->opd_id);
        }

        $jabatan = $query->paginate(10);

        return view('backend.jabatan.list_jabatan', compact('jabatan'));
    }



    public function create()
    {
        return view('backend.jabatan.create_jabatan');
    }

    public function store(Request $request)
    {
        $jabatan = new Jabatan($request->all());
        $jabatan->save();
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil ditambahkan!');
    }

    public function show($id)
    {
        $jabatan = Jabatan::find($id);
        return view('backend.jabatan.show', compact('jabatan'));
    }

    public function edit($id)
    {
        $jabatan = Jabatan::find($id);
        return view('backend.jabatan.edit_jabatan', compact('jabatan'));
    }

    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::find($id);
        $jabatan->update($request->all());
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jabatan = jabatan::find($id);
        $jabatan->delete();
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus!');
    }
}
