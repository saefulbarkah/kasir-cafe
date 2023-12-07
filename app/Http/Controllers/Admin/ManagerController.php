<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Manager;
use App\User;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manager = Manager::join('users', 'users.id', '=', 'manager.user_id')
            ->select('manager.*', 'manager.id as manager_id', 'users.id as id_user', 'users.*')->get();
        return view('admin.manager.index', compact('manager'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.manager.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'nama_lengkap' => 'required',
                'email'        => 'required|email|unique:users,email',
                'password'      => 'required|min:8',
            ],
            [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.unique' => 'Email sudah di gunakan',
                'email.email' => 'Alamat email tidak valid',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
            ]
        );

        $user = new user();
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->assignRole('manager');
        $user->save();

        $manager = new Manager();
        $manager->user_id = $user->id;
        $manager->save();

        return redirect()->route('admin.manager')->with('success', 'Data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manager = Manager::join('users', 'users.id', '=', 'manager.user_id')
            ->select('manager.*', 'manager.id as manager_id', 'users.id as id_user', 'users.*')->findOrFail($id);
        return view('admin.manager.edit', compact('manager'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $manager = Manager::findOrFail($id);
        $user = User::findOrFail($manager->user_id);

        // make validation
        $request->validate(
            [
                'nama_lengkap' => 'required',
                'email'        => 'required|email|unique:users,email,' . $user->id,
            ],
            [
                'nama_lengkap.required' => 'Nama lengkap wajib diisi',
                'email.email' => 'Alamat email tidak valid',
                'email.required' => 'Email wajib diisi',
                'email.unique' => 'Email sudah di gunakan',
            ]
        );
        // updating user
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;

        // check if value password not null and do updating password
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }

        // save updating from request
        $user->save();

        return redirect()->route('admin.manager')->with('success', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manager = Manager::findOrFail($id);
        $user    = User::findOrFail($manager->user_id);
        $user->delete();
        return redirect()->back()->with('success', 'Data berhasil di hapus');
    }
}
