<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pegawai = Pegawai::all();
        return view('backend.pegawai.list_pegawai', compact('pegawai'));
    }

    public function create()
    {
        return view('backend.pegawai.create_pegawai');
    }

    public function store(Request $request)
    {
        
        $pegawai = new Pegawai($request->all());
        $pegawai->save();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan!');
    }

    public function show($id)
    {
        $pegawai = Pegawai::find($id);
        return view('backend.pegawai.show', compact('pegawai'));
    }

    public function edit($id)
    {
        $pegawai = Pegawai::find($id);
        return view('backend.pegawai.edit_pegawai', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::find($id);
        $pegawai->update($request->all());
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::find($id);
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus!');
    }
}
