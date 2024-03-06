<?php

namespace App\Http\Controllers\Backend;

use App\Models\Bidang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BidangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Bidang::query();
        if ($request->has('nama')) {
            $query->where('name', 'like', '%' . $request->nama . '%');
        }

        if (Auth::user()->role == 1) {
            $query->where('opd_id', Auth::user()->opd_id);
        }


        $bidang = $query->paginate(10);

        return view('backend.bidang.list_bidang', compact('bidang'));
    }

    public function create()
    {
        return view('backend.bidang.create_bidang');
    }

    public function store(Request $request)
    {
        $bidang = new Bidang($request->all());
        $bidang->save();
        return redirect()->route('bidang.index')->with('success', 'Bidang berhasil ditambahkan!');
    }

    public function show($id)
    {
        $bidang = Bidang::find($id);
        return view('backend.bidang.show', compact('bidang'));
    }

    public function edit($id)
    {
        $bidang = Bidang::find($id);
        return view('backend.bidang.edit_bidang', compact('bidang'));
    }

    public function update(Request $request, $id)
    {
        $bidang = Bidang::find($id);
        $bidang->update($request->all());
        return redirect()->route('bidang.index')->with('success', 'Bidang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $bidang = Bidang::find($id);
        $bidang->delete();
        return redirect()->route('bidang.index')->with('success', 'Bidang berhasil dihapus!');
    }
}
