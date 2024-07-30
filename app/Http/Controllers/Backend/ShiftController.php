<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shift = Shift::all();
        return view('backend.shift.list_shift', compact('shift'));
    }

    public function store(Request $request)
    {
        $shift = new Shift($request->all());
        $shift->save();
        return redirect()->route('shift.index')->with('success', 'Shift berhasil ditambahkan!');
    }

    public function show($id)
    {
        $shift = Shift::find($id);
        return view('backend.shift.show', compact('shift'));
    }

    public function update(Request $request, $id)
    {
        $shift = Shift::find($id);
        $shift->update($request->all());
        return redirect()->route('shift.index')->with('success', 'Shift berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $shift = Shift::find($id);
        $shift->delete();
        return redirect()->route('shift.index')->with('success', 'Shift berhasil dihapus!');
    }
}
