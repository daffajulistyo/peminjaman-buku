<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pangkat;
use Illuminate\Http\Request;

class PangkatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pangkat = Pangkat::all();
        return view('backend.pangkat.list_pangkat', compact('pangkat'));
    }

    public function create()
    {
        return view('backend.pangkat.create_pangkat');
    }

    public function store(Request $request)
    {
        $pangkat = new Pangkat($request->all());
        $pangkat->save();
        return redirect()->route('pangkat.index')->with('success', 'Pangkat berhasil ditambahkan!');
    }

    public function show($id)
    {
        $pangkat = Pangkat::find($id);
        return view('backend.pangkat.show', compact('pangkat'));
    }

    public function edit($id)
    {
        $pangkat = Pangkat::find($id);
        return view('backend.pangkat.edit_pangkat', compact('pangkat'));
    }

    public function update(Request $request, $id)
    {
        $pangkat = Pangkat::find($id);
        $pangkat->update($request->all());
        return redirect()->route('pangkat.index')->with('success', 'Pangkat berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pangkat = Pangkat::find($id);
        $pangkat->delete();
        return redirect()->route('pangkat.index')->with('success', 'Pangkat berhasil dihapus!');
    }
}
