<?php

namespace App\Http\Controllers\Backend;

use App\Models\Eselon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EselonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $eselon = Eselon::all();
        return view('backend.eselon.list_eselon', compact('eselon'));
    }

    public function store(Request $request)
    {
        $eselon = new Eselon($request->all());
        $eselon->save();
        return redirect()->route('eselon.index')->with('success', 'Eselon berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $eselon = Eselon::find($id);
        $eselon->delete();
        return redirect()->route('eselon.index')->with('success', 'Eselon berhasil dihapus!');
    }
}
