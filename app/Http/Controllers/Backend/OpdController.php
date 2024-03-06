<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use Illuminate\Http\Request;

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
        return redirect()->route('opd.index')->with('success', 'Opd berhasil ditambahkan!');
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
        return redirect()->route('opd.index')->with('success', 'Opd berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $opd = Opd::find($id);
        $opd->delete();
        return redirect()->route('opd.index')->with('success', 'Opd berhasil dihapus!');
    }
}
