<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        $users = User::all();
        return view('backend.user.list_user', compact('users'));
    }

    public function create()
    {
        return view('backend.user.create_user');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $password = $validatedData['password'];
        $hashedPassword = Hash::make($password);

        $user = new User;
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = $hashedPassword;
        $user->save();

        return redirect()->route('user.index')
                         ->with('success', 'Anggota berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('backend.user.edit_user', compact('user'));
    }

    public function update(Request $request, User $user, $id)
    {
        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user['role'] = $request->role;
        $update = $user->save();

        if ($update) {

            return Redirect()->route('user.index')->with('success', 'User Updated successfully!');
        } else {

            return Redirect()->route('user.index')->with('error', 'Something is Wrong!');
        }

    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Anggota berhasil dihapus!');
    }
}
