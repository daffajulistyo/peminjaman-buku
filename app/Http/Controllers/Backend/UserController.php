<?php

namespace App\Http\Controllers\Backend;

use DB;
use App\Models\Opd;
use App\Models\User;
use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\Pangkat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;


class UserController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        // Mendapatkan semua pengguna dengan mempertimbangkan kondisi yang diberikan
        $users = User::when(Auth::user()->role == 3, function ($query) {
            // Jika peran pengguna adalah 3, langsung tampilkan semua pengguna
            return $query;
        })
            ->when(Auth::user()->role != 3, function ($query) {
                // Jika peran pengguna bukan 3, tampilkan sesuai dengan opd-nya
                return $query->where('role', 2)
                    ->whereHas('opd', function ($q) {
                        $q->where('name', Auth::user()->opd->name);
                    });
            })
            // Filter berdasarkan pencarian
            ->when($request->has('nama'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->nama . '%');
            })
            ->when($request->has('nip'), function ($query) use ($request) {
                $query->where('nip', 'like', '%' . $request->nip . '%');
            })
            ->paginate(10);

        return view('backend.pegawai.list_pegawai', compact('users'));
    }


    public function create()
    {
        $opds = Opd::all();
        $bidangs = Bidang::all();
        $jabatans = Jabatan::all();
        $pangkats = Pangkat::all();

        return view('backend.pegawai.create_pegawai', compact('opds', 'bidangs', 'jabatans', 'pangkats'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'eselon_id' => 'nullable',
            'password' => 'required|min:8',
            'nip' => 'nullable',
            'status' => 'required',
            'opd_id' => 'nullable',
            'jabatan_id' => 'nullable',
            'pangkat_id' => 'nullable',
        ]);

        $password = $validatedData['password'];
        $hashedPassword = Hash::make($password);

        $user = new User;
        $user->name = $validatedData['name'];
        $user->eselon_id = $validatedData['eselon_id'];
        $user->password = $hashedPassword;
        $user->nip = $validatedData['nip'];
        $user->status = $validatedData['status'];
        $user->opd_id = $validatedData['opd_id'];
        $user->jabatan_id = $validatedData['jabatan_id'];
        $user->pangkat_id = $validatedData['pangkat_id'];
        $user->save();

        return redirect()->route('user.index')
            ->with('success', 'Anggota berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('user.index')->with('error', 'User not found.');
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'role' => 'required',
            'nip' => 'nullable',
            'status' => 'nullable',
            'nohp' => 'nullable',
            'opd_id' => 'nullable',
            'bidang_id' => 'nullable',
            'jabatan_id' => 'nullable',
            'pangkat_id' => 'nullable',
            'akses' => 'required',
            'laporan_akses' => 'nullable',
            'eselon_id' => 'nullable',
        ]);

        $user->name = $validatedData['name'];
        $user->eselon_id = $validatedData['eselon_id'];
        $user->role = $validatedData['role'];
        $user->nip = $validatedData['nip'];
        $user->status = $validatedData['status'];
        $user->nohp = $validatedData['nohp'];
        $user->opd_id = $validatedData['opd_id'];
        $user->bidang_id = $validatedData['bidang_id'];
        $user->jabatan_id = $validatedData['jabatan_id'];
        $user->pangkat_id = $validatedData['pangkat_id'];
        $user->akses = $validatedData['akses'];
        $user->laporan_akses = $validatedData['laporan_akses'];

        $update = $user->save();

        if ($update) {
            return redirect()->route('user.index')->with('success', 'Anggota Berhasil Diperbarui');
        } else {
            return redirect()->route('user.index')->with('error', 'Something is Wrong!');
        }
    }


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Anggota berhasil dihapus!');
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        $request->validate([
            'password' => 'required|min:8',
        ]);

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->back()->with('success', 'Password pengguna berhasil direset.');
    }

    public function getUsersByOpd($opdId)
    {
        $users = User::where('opd_id', $opdId)->get();

        return response()->json(['users' => $users]);
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // Toggle user status
        $user->is_active = $user->is_active == 1 ? 0 : 1;
        $user->save();

        return redirect()->back()->with('success', 'Status pengguna berhasil diperbarui.');
    }
}
