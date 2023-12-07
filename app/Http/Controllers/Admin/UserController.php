<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $data = User::all();
        return view('admin.data_user.index', compact('data'));
    }

    public function create()
    {
        $role = Role::all();
        return view('admin.data_user.create', compact('role'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'nama_lengkap' => 'required',
                'email'        => 'required|email|unique:users,email',
                'password'      => 'required|min:8',
                'role'      => 'required',
            ],
            [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.unique' => 'Email sudah di gunakan',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'role.required'         => 'Peran wajib di pilih',
            ]
        );

        $user = new User();
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->assignRole($request->role);
        $user->save();
        return redirect()->route('admin.manage.user')->with('success', 'Data berhasil di tambahkan');
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $role = Role::all();
        return view('admin.data_user.edit', compact('user', 'role'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->password != null) {
            $request->validate(
                [
                    'nama_lengkap'  => 'required',
                    'role'          => 'required',
                    'email'         => 'required|email|unique:users,email,' . $user->id,
                    'password'      => 'min:8',
                ],
                [
                    'nama_lengkap.required' => 'Nama lengkap wajib diisi',
                    'role.required'         => 'Peran wajib di pilih',
                    'email.required' => 'Email wajib diisi',
                    'email.unique' => 'Email sudah di gunakan',
                    'password.min' => 'Password baru minimal 8 karakter',
                ]
            );
        }
        $request->validate(
            [
                'nama_lengkap'  => 'required',
                'role'          => 'required',
                'email'         => 'required|email|unique:users,email,' . $user->id,
            ],
            [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi',
                'role.required'         => 'Peran wajib di pilih',
                'email.required' => 'Email wajib diisi',
                'email.unique' => 'Email sudah di gunakan',
            ]
        );

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }
        $user->syncRoles($request->role);
        $user->save();

        return redirect()->route('admin.manage.user')->with('success', 'Data berhasil di update');
    }


    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.manage.user')->with('success', 'Data berhasil di hapus');
    }
    public function ubahPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back()->with('pwd', 'Kata sandi berhasil di update');
    }
}
